<?php

namespace Modules\LlmModule\Services;

use App\Http\Services\Http\HttpClientService;

class LLMManager
{
    protected $config;
    protected $httpClient;

    public function __construct()
    {
        $this->config = config('llmmodule');
        $this->httpClient = new HttpClientService([
            'timeout' =>30,
        ]);
    }

    public function getDefaultLLM()
    {
        $default = $this->config['default'];

        return $this->getLLM($default);
    }

    public function getLlmByAction($action)
    {
        $adaptator = $this->config['actions'][$action];
        if (!$adaptator) $adaptator = $this->config['default'];

        return $this->getLLM($adaptator);
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
        $model = $driverConfig['model'] ?? null;

        return new $class($apiKey, $baseUrl, $model, $this->httpClient);
    }
}
