<?php

return [
    // General configurations for the module
    'name' => 'AuthXdirModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'example_service' => \Modules\AuthXdirModule\Services\ExampleService::class,
    ],
];