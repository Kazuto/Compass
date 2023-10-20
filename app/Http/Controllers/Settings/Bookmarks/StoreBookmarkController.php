<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\StoreBookmarkAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookmarks\StoreBookmarkRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreBookmarkController extends Controller
{
    public function __invoke(StoreBookmarkRequest $request): RedirectResponse
    {
        return raid(
            'Store Bookmark',
            fn (Raid $raid) => $this->handle($request, $raid)
        );
    }

    private function handle(StoreBookmarkRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request, $raid) {
                $raid->debug('Calling Action', ['action' => StoreBookmarkAction::class]);

                app(StoreBookmarkAction::class)->execute($request->validated());

                Session::flash('success', 'The bookmark was added successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.list'));
    }
}
