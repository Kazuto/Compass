<?php

declare(strict_types=1);

namespace App\Routes;

use App\Http\Controllers\Auth\CallbackController;
use App\Http\Controllers\Auth\IndexController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\Auth\RedirectController;
use Illuminate\Support\Facades\Route;

class AuthRoutes implements RouteGroup
{
    public static function register()
    {
        Route::as('auth.')
            ->group(function () {
                Route::get('/login', IndexController::class)
                    ->middleware('guest')
                    ->name('index');

                Route::get('/logout', LogOutController::class)
                    ->middleware('auth')
                    ->name('logout');

                Route::prefix('/auth')
                    ->middleware('guest')
                    ->group(function () {
                        Route::get('/redirect', RedirectController::class)->name('redirect');
                        Route::get('/callback', CallbackController::class)->name('callback');
                    });
            });
    }
}
