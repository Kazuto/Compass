<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\CallbackController;
use App\Http\Controllers\Auth\RedirectController;
use App\Http\Controllers\Auth\SignOutController;
use Illuminate\Support\Facades\Route;

Route::as('compass.')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::prefix('/auth')
        ->as('auth.')
        ->group(function () {
            Route::get('/redirect', RedirectController::class)->name('redirect');
            Route::get('/callback', CallbackController::class)->name('callback');
            Route::get('/sign-out', SignOutController::class)->name('sign-out');
        });
});
