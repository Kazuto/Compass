<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\DeleteBookmarkGroupAction;
use App\Http\Controllers\Controller;
use App\Models\BookmarkGroup;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteBookmarkGroupController extends Controller
{
    public function __invoke(BookmarkGroup $bookmarkGroup): RedirectResponse
    {
        return raid(
            'Delete Bookmark Group',
            fn (Raid $raid) => $this->handle($bookmarkGroup, $raid)
        );
    }

    private function handle(BookmarkGroup $bookmarkGroup, Raid $raid): RedirectResponse
    {
        $raid->addContext('bookmarkGroupId', $bookmarkGroup->id);

        try {
            DB::transaction(function () use ($bookmarkGroup) {
                app(DeleteBookmarkGroupAction::class)->execute($bookmarkGroup);

                Session::flash('success', 'The bookmark group was deleted successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.list'));
    }
}
