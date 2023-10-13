<?php

declare(strict_types=1);

return [
    'theme' => [
        'colors' => [
            'text' => env('TEXT_COLOR', '#ffffff'),
            'accent' => env('ACCENT_COLOR', '#c6a375'),
            'background' => env('BACKGROUND_COLOR', '#142534'),
        ],
    ],

    'admin' => [
        'username' => env('ADMIN_USERNAME', 'admin'),
        'email' => env('ADMIN_EMAIL', 'admin@app.test'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],
];
