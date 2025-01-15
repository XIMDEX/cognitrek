<?php

return [
    'xdir' => [
        'uri' => env('XDAM_URI'),
        'auth' => 'xdir',
        'login_endpoint' => env('XDAM_URI') . '/login',
        'username' => env('XDIR_USERNAME'),
        'password' => env('XDIR_PASSWORD')
    ],
    'xdam' => [
        'uri' => env('XDAM_URI'),
        'auth' => env('XDAM_AUTH', 'xdir'),
        'login_endpoint' => env('XDAM_URI') . '/login',
        'username' => env('XDAM_USERNAME'),
        'password' => env('XDAM_PASSWORD')
    ]
];