<?php

declare(strict_types=1);

namespace App\Routes;

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

class AppRoutes implements RouteGroup
{
    public static function register()
    {
        Route::middleware('auth')
            ->group(function () {
                Route::get('/', DashboardController::class)->name('home');
            });
    }
}
