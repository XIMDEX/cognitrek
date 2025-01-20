<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Http\Services\Http\HttpClientService;

class LlamaAdapter extends LLMBaseAdapter
{
    public function __construct($apiKey, $baseUrl, $model, HttpClientService $httpClient)
    {
        parent::__construct($apiKey, $baseUrl, $model, $httpClient);
    }

    public function call($prompt, array $options = []): string
    {
        // Ajustar según las especificaciones de la API de Llama:
        $model = $options['model'] ?? 'llama-default-model';
        $maxTokens = $options['max_tokens'] ?? 150;

        $response = $this->httpClient->request('POST', $this->baseUrl . '/v1/generate', [
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

        // Ajustar el parseo dependiendo de la respuesta de Llama
        return $response['data']['text'] ?? '';
    }

    public function batch(array $prompts, array $options = []): array
    {
        // Ajustar según las especificaciones de la API de Llama:
        $model = $options['model'] ?? 'llama-default-model';
        $maxTokens = $options['max_tokens'] ?? 150;

        $responses = [];
        foreach ($prompts as $prompt) {
            $response = $this->httpClient->request('POST', $this->baseUrl . '/v1/generate', [
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

            // Ajustar el parseo dependiendo de la respuesta de Llama
            $responses[] = $response['data']['text'] ?? '';
        }

        return $responses;
    }


}
