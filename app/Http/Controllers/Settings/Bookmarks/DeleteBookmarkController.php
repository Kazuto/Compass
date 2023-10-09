<?php

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteBookmarkController extends Controller
{
    public function __invoke(Bookmark $bookmark): RedirectResponse
    {
        // For redirection
        $bookmarkGroup = $bookmark->bookmarkGroup;

        try {
            DB::transaction(function () use ($bookmark) {
                $bookmark->delete();

                Session::flash('success', 'The bookmark was deleted successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));
    }
}
