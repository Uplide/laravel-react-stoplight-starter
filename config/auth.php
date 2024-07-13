<?php

return [

    'defaults' => [
        'guard' => 'web',
        "password" => "admins"
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'admin-api' => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],

        'user-api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'users' => [
            'provider' => 'users',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
