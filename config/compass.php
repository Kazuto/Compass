<?php

declare(strict_types=1);

return [
    'admin' => [
        'username' => env('ADMIN_USERNAME', 'admin'),
        'email' => env('ADMIN_EMAIL', 'admin@app.test'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],
];
