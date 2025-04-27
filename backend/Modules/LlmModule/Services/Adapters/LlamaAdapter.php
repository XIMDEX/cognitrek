<?php

namespace Modules\LlmModule\Services\Adapters;

use App\Http\Services\Http\HttpClientService;

class LlamaAdapter extends LLMBaseAdapter
{
    public function __construct($apiKey, $baseUrl, $model, HttpClientService $httpClient)
    {
        parent::__construct($apiKey, $baseUrl, $model, $httpClient);
    }

}
