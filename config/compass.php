<?php

declare(strict_types=1);

return [
    'version' => '0.9.0',

    'admin' => [
        'username' => env('ADMIN_USERNAME', 'admin'),
        'email' => env('ADMIN_EMAIL', 'admin@app.test'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],
];
