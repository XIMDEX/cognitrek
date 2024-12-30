<?php

return [
    // General configurations for the module
    'name' => 'LlmModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'example_service' => \Modules\LlmModule\Services\ExampleService::class,
    ],
];