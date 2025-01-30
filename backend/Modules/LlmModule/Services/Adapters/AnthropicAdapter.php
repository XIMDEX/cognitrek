<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Http\Services\Http\HttpClientService;

class AnthropicAdapter extends LLMBaseAdapter
{
    public function __construct($apiKey, $baseUrl, $model, HttpClientService $httpClient)
    {
        parent::__construct($apiKey, $baseUrl, $model, $httpClient);
    }

    public function call($prompt, array $options = [], $path=null): string
    {
        // Ajustar según las especificaciones de la API de Anthropic:
        $model = $options['model'] ?? 'claude-v1';
        $maxTokens = $options['max_tokens'] ?? 150;

        $response = $this->httpClient->request('POST', $this->baseUrl . '/v1/complete', [
            'headers' => [
                'x-api-key' => $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'prompt' => $prompt,
                'model'  => $model,
                'max_tokens_to_sample' => $maxTokens,
            ]
        ]);

        // Ajustar el parseo dependiendo de la respuesta de Anthropic
        return $response['completion'] ?? '';
    }

}
