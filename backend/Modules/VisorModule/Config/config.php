<?php

return [
    // General configurations for the module
    'name' => 'VisorModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'visor_service' => \Modules\VisorModule\Services\VisorService::class,
    ]
];
