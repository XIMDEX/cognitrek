<?php

return [
    'name' => 'LlmModule',
    'version' => '1.0.0',
    'default' => env('DEFAULT_LLM', 'OpenAI'),

    'services' => [
        'llm_service' => \Modules\LlmModule\Services\LLMService::class,
    ],

    'drivers' => [
        'OpenAI' => [
            'class' => \Modules\LlmModule\Services\Adapters\OpenAIAdapter::class,
            'api_key' => env('OPENAI_API_KEY', ''),
            'base_url' => env('OPENAI_API_URL', 'https://api.openai.com'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'endpoints' => [
                'chat' => '/v1/chat/completions',
                'files' => '/v1/files',
                'batches' => '/v1/batches',
            ],
        ],
        'Anthropic' => [
            'class' => \Modules\LlmModule\Services\Adapters\AnthropicAdapter::class,
            'api_key' => env('ANTHROPIC_API_KEY', ''),
            'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com'),
            'model' => env('ANTHROPIC_MODEL', 'soonet-3.5'),
        ],
        'Llama' => [
            'class' => \Modules\LlmModule\Services\Adapters\LlamaAdapter::class,
            'api_key' => env('LLAMA_API_KEY', ''),
            'base_url' => env('LLAMA_BASE_URL', 'https://api.llama.com'),
            'model' => env('LLAMA_MODEL', 'llama-default-model'),
        ],
    ],
    'prompts' => [
        'resume' => storage_path('Prompts/resume.txt'),
        'conceptual_map' => storage_path('Prompts/conceptual_map.txt'),
        'dyslexia' => [
            'low' => storage_path('Prompts/dyslexia/low.txt'),
            'mid' => storage_path('Prompts/dyslexia/mid.txt'),
            'hight' => storage_path('Prompts/dyslexia/hight.txt')
        ],
        'attention_deficit' => [
            'low' => storage_path('Prompts/attention_deficit/low.txt'),
            'mid' => storage_path('Prompts/attention_deficit/mid.txt'),
            'hight' => storage_path('Prompts/attention_deficit/hight.txt')
        ],
        'autism' => [
            'low' => storage_path('Prompts/autism/low.txt'),
            'mid' => storage_path('Prompts/autism/mid.txt'),
            'hight' => storage_path('Prompts/autism/hight.txt')
        ],
        'visual_impairment' => [
            'low' => storage_path('Prompts/visual_impairment/low.txt'),
            'mid' => storage_path('Prompts/visual_impairment/mid.txt'),
            'hight' => storage_path('Prompts/visual_impairment/hight.txt')
        ],
        'hearing_impairment' => [
            'low' => storage_path('Prompts/hearing_impairment/low.txt'),
            'mid' => storage_path('Prompts/hearing_impairment/mid.txt'),
            'hight' => storage_path('Prompts/hearing_impairment/hight.txt')
        ],
        'language_disorder' => [
            'low' => storage_path('Prompts/language_disorder/low.txt'),
            'mid' => storage_path('Prompts/language_disorder/mid.txt'),
            'hight' => storage_path('Prompts/language_disorder/hight.txt')
        ],
    ]
];
