<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Http\Services\Http\HttpClientService;

class OpenAIAdapter extends LLMBaseAdapter
{
    public function __construct($apiKey, $baseUrl, $model, HttpClientService $httpClient)
    {
        parent::__construct($apiKey, $baseUrl, $model, $httpClient);
    }

    public function call($prompt, array $options = []): string
    {
        $model = $this->model;

        $response = $this->httpClient->request('POST', $this->baseUrl , [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $prompt]
                ],
                'temperature' => 1,
                'max_tokens' => 10000,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0
            ]
        ]); 

        return $response['choices'][0]['message']['content'] ?? '';
    }
}
