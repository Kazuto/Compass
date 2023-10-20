<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\StoreBookmarkGroupAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookmarks\StoreBookmarkGroupRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreBookmarkGroupController extends Controller
{
    public function __invoke(StoreBookmarkGroupRequest $request): RedirectResponse
    {
        return raid(
            'Store Bookmark Group',
            fn (Raid $raid) => $this->handle($request, $raid)
        );
    }

    private function handle(StoreBookmarkGroupRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request, $raid) {
                $raid->debug('Calling Action', ['action' => StoreBookmarkGroupAction::class]);

                app(StoreBookmarkGroupAction::class)->execute($request->validated());

                Session::flash('success', 'The bookmark group was added successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.list'));
    }
}
