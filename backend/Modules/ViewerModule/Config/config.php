<?php

return [
    // General configurations for the module
    'name' => 'ViewerModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'example_service' => \Modules\ViewerModule\Services\ExampleService::class,
    ],
];