<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Http\Services\Http\HttpClientService;

class OpenAIAdapter extends LLMBaseAdapter
{

    const STATUS_FILE_UPLOAD_OK = 'processed';
    const STATUS_OK = 'ok';

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
        $output = ['id' => false, 'content' => [], 'error' => false];
        $outputFileId = false;
        $batchId = $options['batch_id'] ?? false;
        $filePath = false;

        $maxAttempts = 0;
        $timeSleep = 0;

        if (isset($options['maxAttempts'])) {
            $maxAttempts = $options['maxAttempts'];
        }
        if (isset($options['timeSleep'])) {
            $timeSleep = $options['timeSleep'];
        }
        try {
            if (!$batchId) {
                $options_batch =  [
                    'temperature' => $options['temperature'] ?? 1,
                    'max_tokens' => $options['max_tokens'] ?? 10000,
                    'top_p' => $options['top_p'] ?? 1,
                    'frequency_penalty' => $options['frequency_penalty'] ?? 0,
                    'presence_penalty' => $options['presence_penalty'] ?? 0,
                ];
                $filePath = $this->createJsonlFile($data, $prompt, $options_batch);
                $fileId = $this->uploadFile($filePath);
                $batchId = $this->createBatch($fileId, $options);
                $output['batch_id'] = $batchId;
                $output['id'] = $batchId;
            }
            $outputFileId = $this->monitorBatch($batchId, $maxAttempts, $timeSleep);
            if (in_array($outputFileId, array_values(self::STATUS_ERROR))) {
                $output['id'] = $batchId;
                if ($outputFileId === self::STATUS_ERROR[1]) {
                    $this->deleteBatchAndFile($batchId);
                    $output['error'] = true;
                    $output['id'] = false;
                } else {
                    $output['maxAttempts'] = 5;
                    $output['timeSleep'] = 60;
                }
            } else {
                $content = $this->downloadBatchResults($outputFileId);
                if ($content['status'] === self::STATUS_ERROR[3]) {
                    $this->deleteBatchAndFile($batchId);
                    $output['id'] = false;
                    $output['error'] = true;
                    $output['content'] = ['error' => 'Error processing step batch'];
                }
                $output['id'] = false;
                $output['error'] = false;
                $output['content'] = $content['data'];
            }
            return $output;
        } catch (\Throwable $th) {
            if ($batchId) {
                $this->deleteBatchAndFile($batchId);
            } elseif ($outputFileId) {
                $this->deleteFile($outputFileId);
            }
            $output['error'] = true;
            $output['id'] = false;
            $output['content'] = ['error' => 'Error processing batch'];
            return $output;
        } finally {
            if ($filePath) unlink($filePath);
        }
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

    private function monitorBatch(string $batchId, $maxAttempts = 0, $timeSleep = 0): string
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . $this->endpoints['batches'] . '/' . $batchId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        $status = $response['status'] ?? 'unknown';

        if ($status === 'completed') {
            return $response['output_file_id'] ?? self::STATUS_ERROR[3];
        }

        if ($status !== 'in_progress' && $status !== 'validating') {
            return self::STATUS_ERROR[1];
        }

        return self::STATUS_ERROR[2];
    }

    private function downloadBatchResults(string $outputFileId)
    {
        try {
            $response = $this->httpClient->request('GET', $this->baseUrl . $this->endpoints['files'] . '/' . $outputFileId . '/content', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ], false);

            $response = $response->getBody()->getContents();
            $response = array_map('json_decode', explode("\n", trim($response)));


            if (empty($response)) {
                return self::STATUS_ERROR[1];
            }

            $data = $this->decodeResponseBatch($response);
            return ['data' => $data, 'status' => self::STATUS_OK];
        } catch (\Throwable $th) {
            return ['data' => [], 'status' => self::STATUS_ERROR[3]];
        }
    }

    private function decodeResponseBatch($lines)
    {
        foreach ($lines as $line) {
            if ($line->error != null) {
                $output[] = [];
            }
            $id = $line->custom_id;
            if (str_starts_with($id, "request_")) $id = str_replace('request_', '', $id);
            $id = intval($id);
            $data = $line->response->body->choices[0]->message->content;

            if (str_starts_with($data, "```json")) {
                $data = substr($data, 7);
            }
            if (str_ends_with($data, "```")) {
                $data = substr($data, 0, -3);
            }
            $output[$id] = json_decode($data, true) ?? [];
        }
        return $output;
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

        $response = $this->httpClient->request('POST', $this->baseUrl . $this->endpoints['batches'] . '/' . $batchId . '/cancel', [
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
            if ($batch !== self::STATUS_ERROR[1]) {
                $this->deleteBatch($batchId);
            }
            return true;
        } catch(\Throwable $th) {
            throw new \Exception('Failed to delete batch and file with ID: ' . $batchId);
        }

    }
}
