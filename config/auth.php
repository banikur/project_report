<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    // Guard
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
        'manager' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
        'purchasing' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
        'koki' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
        'cashier' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
    ],
    //  Providers
    'providers' => [
        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
    // Password
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
];
