<?php

declare(strict_types=1);

namespace App\Routes;

use App\Http\Controllers\Settings\Bookmarks\CreateBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\ListBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\ShowBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\StoreBookmarkGroupController;
use App\Http\Controllers\Settings\IndexController;
use Illuminate\Support\Facades\Route;

class SettingsRoutes implements RouteGroup
{
    public static function register()
    {
        Route::as('settings.')
            ->prefix('settings/')
            ->middleware('auth')
            ->group(function () {
                Route::get('/', IndexController::class)->name('index');

                Route::as('bookmarks.')
                    ->prefix('bookmarks/')
                    ->group(function () {
                        Route::get('/', ListBookmarkGroupController::class)->name('list');
                    });
            });
    }
}
