<?php

return [
    // General configurations for the module
    'name' => 'AuthXdirModule',
    'version' => '1.0.0',

    // Register services
    'services' => [
        'xauth_service' => \Modules\AuthXdirModule\Services\XAuthService::class,
        'is_authenticated_service' => \Modules\AuthXdirModule\Services\IsAuthenticatedService::class,
    ],

    'xdir' => [
        'url' => env('XDIR_URI', 'https://xdir-back.ximdex.net/api'),
        'version' => env('XDIR_VERSION', 'v1'),
        'client_id' => env('XDIR_CLIENT_ID', 'CT01'),
        'public_key_path' => env('XDIR_KEY_PATH', __DIR__ . '../lib/xrole/oauth-public.key'),
    ],
    'xdam' => [
        'url' => env('XDAM_URI', 'https://xdam-back.ximdex.net/api'),
        'version' => env('XDAM_VERSION', 'v1'),
    ]
];
