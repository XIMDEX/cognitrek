<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Services\Http\HttpClientService;

abstract class LLMBaseAdapter
{
    protected $apiKey;
    protected $baseUrl;
    protected $httpClient;

    /**
     * @param string $apiKey
     * @param string $baseUrl
     * @param HttpClientService $httpClient
     */
    public function __construct($apiKey, $baseUrl, HttpClientService $httpClient)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->httpClient = $httpClient;
    }

    /**
     * Método abstracto que cada adaptador debe implementar para realizar una llamada al LLM.
     * 
     * @param string $prompt
     * @param array  $options Opciones adicionales específicas para cada modelo (max_tokens, model, etc.)
     * @return string La respuesta generada por el LLM
     */
    abstract public function call($prompt, array $options = []): string;
}