<?php

return [
    // General configurations for the module
    'name' => 'ExampleModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'example_service' => \Modules\ExampleModule\Services\ExampleService::class,
    ],
];