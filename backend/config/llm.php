<?php


use App\Services\LLM\Adapters\OpenAIAdapter;
use App\Services\LLM\Adapters\AnthropicAdapter;
use App\Services\LLM\Adapters\LlamaAdapter;

return [
    'default' => env('DEFAULT_LLM', 'OpenAI'),

    'drivers' => [
        'OpenAI' => [
            'class' => OpenAIAdapter::class,
            'api_key' => env('OPENAI_API_KEY', ''),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com'),
        ],
        'Anthropic' => [
            'class' => AnthropicAdapter::class,
            'api_key' => env('ANTHROPIC_API_KEY', ''),
            'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com'),
        ],
        'Llama' => [
            'class' => LlamaAdapter::class,
            'api_key' => env('LLAMA_API_KEY', ''),
            'base_url' => env('LLAMA_BASE_URL', 'https://api.llama.com'),
        ],
        // Agrega más drivers aquí
    ],
];