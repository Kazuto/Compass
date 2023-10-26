<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\UpdateBookmarkAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookmarks\UpdateBookmarkRequest;
use App\Models\Bookmark;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class UpdateBookmarkController extends Controller
{
    public function __invoke(UpdateBookmarkRequest $request, Bookmark $bookmark): RedirectResponse
    {
        return raid(
            'Update Bookmark',
            fn (Raid $raid) => $this->handle($request, $bookmark, $raid)
        );
    }

    private function handle(UpdateBookmarkRequest $request, Bookmark $bookmark, Raid $raid): RedirectResponse
    {
        $raid
            ->addContext('bookmarkId', $bookmark->id)
            ->addContext('data', $request->validated());

        // For redirection in case the group was changed
        $bookmarkGroup = $bookmark->bookmarkGroup;

        try {
            DB::transaction(function () use ($request, $bookmark, $raid) {
                $raid->debug('Calling Action', ['action' => UpdateBookmarkAction::class]);

                app(UpdateBookmarkAction::class)->execute($bookmark, $request->validated());

                Session::flash('success', 'The bookmark was updated successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));
    }
}
