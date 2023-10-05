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

    'auth' => [
        'whitelist_admin_email' => env('WHITELIST_ADMIN_EMAIL'),
    ],
];
