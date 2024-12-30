<?php

namespace Modules\LlmModule\Services;

use App\Services\Http\HttpClientService;

class LLMManager
{
    protected $config;
    protected $httpClient;

    public function __construct()
    {
        $this->config = config('llm');
        $this->httpClient = new HttpClientService([
            'timeout' =>30,
        ]);
    }

    public function getDefaultLLM()
    {
        $default = $this->config['default'];
        
        return $this->getLLM($default);
    }

    public function getLLM($name)
    {
        $drivers = $this->config['drivers'];

        if (!isset($drivers[$name])) {
            throw new \Exception("El LLM [$name] no está configurado.");
        }

        $driverConfig = $drivers[$name];

        $class = $driverConfig['class'];
        $apiKey = $driverConfig['api_key'] ?? null;
        $baseUrl = $driverConfig['base_url'] ?? null;

        return new $class($apiKey, $baseUrl, $this->httpClient);
    }
}