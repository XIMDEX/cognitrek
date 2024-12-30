<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Services\Http\HttpClientService;

class OpenAIAdapter extends LLMBaseAdapter
{
    public function __construct($apiKey, $baseUrl, HttpClientService $httpClient)
    {
        parent::__construct($apiKey, $baseUrl, $httpClient);
    }

    public function call($prompt, array $options = []): string
    {
        // Puedes poner valores por defecto para las opciones, por ejemplo:
        $model = $options['model'] ?? 'text-davinci-003';
        $maxTokens = $options['max_tokens'] ?? 150;

        $response = $this->httpClient->request('POST', $this->baseUrl . '/v1/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => $model,
                'prompt' => $prompt,
                'max_tokens' => $maxTokens,
            ]
        ]);

        return $response['choices'][0]['text'] ?? '';
    }
}