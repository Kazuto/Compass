<?php

declare(strict_types=1);

App\Providers\RouteServiceProvider::registerRoutes([
    App\Routes\AppRoutes::class,
    App\Routes\AuthRoutes::class,
    App\Routes\SettingsRoutes::class,
]);
