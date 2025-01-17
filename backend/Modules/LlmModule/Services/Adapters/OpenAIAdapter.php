<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Http\Services\Http\HttpClientService;

class OpenAIAdapter extends LLMBaseAdapter
{
    const STATUS_ERROR = [
        2 => 'FAILED',
        3 => 'TIMEOUT',
        4 => 'FILE_NOT_FOUND',
    ];

    const STATUS_FILE_UPLOAD_OK = 'processed';

    protected $endpoints;

    public function __construct($apiKey, $baseUrl, $model, HttpClientService $httpClient)
    {
        parent::__construct($apiKey, $baseUrl, $model, $httpClient);
        $this->endpoints = [
            'chat' => config('llmmodule.drivers.OpenAI.endpoints.chat'),
            'files' => config('llmmodule.drivers.OpenAI.endpoints.files'),
            'batches' => config('llmmodule.drivers.OpenAI.endpoints.batches'),
        ];
        
    }

    public function call($prompt, array $options = [], $path=null): string
    {
        if ($path === null) {
            $path =  $this->baseUrl . $this->endpoints['chat'];
        }
        $model = $this->model;

        $response = $this->httpClient->request('POST', $path, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $prompt]
                ],
                'temperature' => $options['temperature'] ?? 1,
                'max_tokens' => $options['max_tokens'] ?? 10000,
                'top_p' => $options['top_p'] ?? 1,
                'frequency_penalty' => $options['frequency_penalty'] ?? 0,
                'presence_penalty' => $options['presence_penalty'] ?? 0
            ]
        ]);

        return $response['choices'][0]['message']['content'] ?? '';
    }

    public function batch(array $data, $prompt = "###XIMDEX_CONTENT###" , array $options = []): array
    {
        $filePath = $this->createJsonlFile($data, $prompt, $options);
        $output = ['id' => false, 'content' => []];
        $outputFileId = false;
        $batchId = false;

        try {
            $fileId = $this->uploadFile($filePath);
            $batchId = $this->createBatch($fileId, $options);
            $status = $outputFileId = $this->monitorBatch($batchId);
            if (in_array($status, array_values(self::STATUS_ERROR))) {
                $output['id'] = $batchId;
                if ($status !== self::STATUS_ERROR[3]) {
                    $this->deleteBatchAndFile($batchId);
                    $output['error'] = true;
                    $output['id'] = false;
                }
            } else {
                $content = $this->downloadBatchResults($outputFileId);
                if ($content === self::STATUS_ERROR[1]) {
                    $this->deleteBatchAndFile($batchId);
                    $output['id'] = false;
                    $output['error'] = true;
                }
                $output['content'] = $content;
            }
            return $output;
        } catch (\Throwable $th) {
            if ($batchId) {
                $this->deleteBatchAndFile($batchId);
            } elseif ($outputFileId) {
                $this->deleteFile($outputFileId);
            }
            $output['error'] = true;
            return $output;
        } finally {
            unlink($filePath);
        }
    }

    private function createJsonlFile(array $data, $prompt, array $options): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'batch_') . '.jsonl';
        $fileHandle = fopen($tempFile, 'w');

        foreach ($data as $item) {
            $data_prompt = str_replace('###XIMDEX_CONTENT###', $item['content'], $prompt);
            $requestBody = [
                'custom_id' => "request_{$item['id']}",
                'method' => 'POST',
                'url' => $this->endpoints['chat'],
                'body' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $data_prompt]
                    ],
                    'temperature' => $options['temperature'] ?? 1,
                    'max_tokens' => $options['max_tokens'] ?? 10000,
                    'top_p' => $options['top_p'] ?? 1,
                    'frequency_penalty' => $options['frequency_penalty'] ?? 0,
                    'presence_penalty' => $options['presence_penalty'] ?? 0,
                ]
            ];

            fwrite($fileHandle, json_encode($requestBody) . "\n");
        }

        fclose($fileHandle);

        return $tempFile;
    }

    private function uploadFile(string $filePath): string
    {
        $response = $this->httpClient->request('POST', $this->baseUrl . $this->endpoints['files'] , [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($filePath, 'r'),
                ],
                [
                    'name' => 'purpose',
                    'contents' => 'batch',
                ],
            ],
        ]);

        if ($response['status'] !== self::STATUS_FILE_UPLOAD_OK || !isset($response['id'])) {
            throw new \Exception('File upload failed: ' . json_encode($response));
        }

        return $response['id'];
    }

    private function createBatch(string $fileId, array $options): string
    {
        $path = $this->baseUrl . $this->endpoints['batches'];
        $response = $this->httpClient->request('POST', $path, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'input_file_id' => $fileId,
                'endpoint' => $this->endpoints['chat'],
                'completion_window' => $options['completion_window'] ?? '24h',
            ],
        ]);

        if (!isset($response['id'])) {
            throw new \Exception('Failed to create the batch: ' . json_encode($response));
        }

        return $response['id'];
    }

    private function monitorBatch(string $batchId): string
    {
        $attempts = 0;
        $maxAttempts = 10;

        do {
            $response = $this->httpClient->request('GET', $this->baseUrl . $this->endpoints['batches'] . '/' . $batchId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ]);

            $status = $response['status'] ?? 'unknown';

            if ($status === 'completed') {
                return $response['output_file_id'] ?? self::STATUS_ERROR[4];
            }

            if ($status === 'failed') {
                return self::STATUS_ERROR[2];
            }

            if (++$attempts >= $maxAttempts) {
                return self::STATUS_ERROR[3];
            }

            sleep(10);
        } while (true);
    }

    private function downloadBatchResults(string $outputFileId): array
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . $this->endpoints['files'] . '/' . $outputFileId . '/content', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        if (empty($response)) {
            return self::STATUS_ERROR[1];
        }

        $decoded = $response;
        return $decoded;
    }

    public function checkBatchStatus(string $batchId): string
    {
        $status = $this->monitorBatch($batchId);
        return $status;
    }

    public function deleteFile(string $fileId): bool
    {
        $response = $this->httpClient->request("POST", $this->baseUrl . $this->endpoints['files'] . '/' . $fileId . '/cancel', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        if ($response['status'] === 200) {
            return true;
        }

        throw new \Exception('Failed to delete file with ID: ' . $fileId);
    }

    public function deleteBatch($batchId) 
    {
        
        $response = $this->httpClient->request('DELETE', $this->baseUrl . $this->endpoints['batches'] . '/' . $batchId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        if ($response['status'] === 200) {
            return true;
        }

        throw new \Exception('Failed to delete batch with ID: ' . $batchId);
    }

    public function deleteBatchAndFile(string $batchId)
    {
        try {
            $batch = $this->checkBatchStatus($batchId);
            $file_id = $batch['input_file_id'] ?? null;
            if ($file_id) {
                $this->deleteFile($file_id);
            }
            $this->deleteBatch($batchId);
            return true;
        } catch(\Throwable $th) {
            throw new \Exception('Failed to delete batch and file with ID: ' . $batchId);
        }

    }
}