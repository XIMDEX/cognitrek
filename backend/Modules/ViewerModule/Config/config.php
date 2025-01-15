<?php

return [
    // General configurations for the module
    'name' => 'ViewerModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'viewer_service' => \Modules\ViewerModule\Services\ViewerService::class,
    ]
];
