<?php

declare(strict_types=1);

namespace App\Routes;

use App\Http\Controllers\Settings\Bookmarks\DeleteBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\ListBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\ShowBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\UpdateBookmarkGroupController;
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
                        Route::post('/group', UpdateBookmarkGroupController::class)->name('groups.store');
                        Route::get('/group/{bookmarkGroup:uuid}', ShowBookmarkGroupController::class)->name('groups.show');
                        Route::patch('/group/{bookmarkGroup:uuid}', UpdateBookmarkGroupController::class)->name('groups.update');
                        Route::delete('/group/{bookmarkGroup:uuid}', DeleteBookmarkGroupController::class)->name('groups.delete');
                    });
            });
    }
}
