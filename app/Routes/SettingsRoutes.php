<?php

declare(strict_types=1);

namespace App\Routes;

use App\Http\Controllers\Settings\Bookmarks\DeleteBookmarkController;
use App\Http\Controllers\Settings\Bookmarks\DeleteBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\ListBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\ShowBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\StoreBookmarkController;
use App\Http\Controllers\Settings\Bookmarks\StoreBookmarkGroupController;
use App\Http\Controllers\Settings\Bookmarks\UpdateBookmarkController;
use App\Http\Controllers\Settings\Bookmarks\UpdateBookmarkGroupController;
use App\Http\Controllers\Settings\General\GeneralController;
use App\Http\Controllers\Settings\General\RebuildThemeController;
use App\Http\Controllers\Settings\Teams\AddUserController;
use App\Http\Controllers\Settings\Teams\DeleteTeamController;
use App\Http\Controllers\Settings\Teams\ListTeamController;
use App\Http\Controllers\Settings\Teams\RemoveUserController;
use App\Http\Controllers\Settings\Teams\ShowTeamController;
use App\Http\Controllers\Settings\Teams\StoreTeamController;
use App\Http\Controllers\Settings\Users\ListUserController;
use App\Http\Controllers\Settings\Users\UpdateUserController;
use App\Http\Controllers\Settings\WhitelistAccess\DeleteWhitelistAccessController;
use App\Http\Controllers\Settings\WhitelistAccess\ListWhitelistAccessController;
use App\Http\Controllers\Settings\WhitelistAccess\StoreWhitelistAccessController;
use Illuminate\Support\Facades\Route;

class SettingsRoutes implements RouteGroup
{
    public static function register()
    {
        Route::as('settings.')
            ->prefix('settings/')
            ->middleware(['auth', 'admin'])
            ->group(function () {
                Route::as('general.')
                    ->prefix('general/')
                    ->group(function () {
                        Route::get('/', GeneralController::class)->name('index');
                        Route::post('/', RebuildThemeController::class)->name('rebuild-theme');
                    });

                Route::as('bookmarks.')
                    ->prefix('bookmarks/')
                    ->group(function () {
                        Route::get('/', ListBookmarkGroupController::class)->name('list');
                        Route::post('/', StoreBookmarkController::class)->name('store');
                        Route::patch('/{bookmark:uuid}', UpdateBookmarkController::class)->name('update');
                        Route::delete('/{bookmark:uuid}', DeleteBookmarkController::class)->name('delete');
                        Route::post('/group', StoreBookmarkGroupController::class)->name('groups.store');
                        Route::get('/group/{bookmarkGroup:uuid}', ShowBookmarkGroupController::class)->name('groups.show');
                        Route::patch('/group/{bookmarkGroup:uuid}', UpdateBookmarkGroupController::class)->name('groups.update');
                        Route::delete('/group/{bookmarkGroup:uuid}', DeleteBookmarkGroupController::class)->name('groups.delete');
                    });

                Route::as('users.')
                    ->prefix('users')
                    ->group(function () {
                        Route::get('/', ListUserController::class)->name('list');
                        Route::patch('/{user:uuid}', UpdateUserController::class)->name('update');
                    });

                Route::as('teams.')
                    ->prefix('teams')
                    ->group(function () {
                        Route::get('/', ListTeamController::class)->name('list');
                        Route::post('/', StoreTeamController::class)->name('store');
                        Route::get('/{team:uuid}', ShowTeamController::class)->name('show');
                        Route::delete('/{team:uuid}', DeleteTeamController::class)->name('delete');

                        Route::post('/{team:uuid}/add-user', AddUserController::class)->name('add-user');
                        Route::post('/{team:uuid}/remove-user', RemoveUserController::class)->name('remove-user');
                    });

                Route::as('whitelist.')
                    ->prefix('whitelist')
                    ->group(function () {
                        Route::get('/', ListWhitelistAccessController::class)->name('list');
                        Route::post('/', StoreWhitelistAccessController::class)->name('store');
                        Route::delete('/{whitelistAccess}', DeleteWhitelistAccessController::class)->name('delete');
                    });
            });
    }
}
