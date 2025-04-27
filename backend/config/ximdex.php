<?php

return [
    'xdir' => [
        'uri' => env('XDIR_URI') . '/' . env('XDIR_VERSION'),
        'auth' => 'xdir',
        'login_endpoint' => env('XDIR_URI') . '/login',
        'enabled' => env('ENABLED_XDIR', false)
    ],
    'xdam' => [
        'uri' => env('XDAM_URI') . '/' . env('XDAM_VERSION'),
        'auth' => env('XDAM_AUTH', 'xdir'),
        'login_endpoint' => env('XDAM_URI') . '/' . env('XDAM_VERSION') . '/auth/login',

    ]
];
