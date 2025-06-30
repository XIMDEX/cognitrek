<?php

return [
    // General configurations for the module
    'name' => 'AnonymizerModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'anonymizer_service' => \Modules\AnonymizerModule\Services\AnonymizerService::class,
    ],

    'secret_phrase' => env('SECRET_PHRASE_ANONYMIZER', 'secret_password'),
    'cipher' => 'AES-256-CBC'
];