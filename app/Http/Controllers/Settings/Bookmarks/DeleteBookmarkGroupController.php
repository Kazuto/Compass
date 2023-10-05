<?php

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Models\BookmarkGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteBookmarkGroupController extends Controller
{
    public function __invoke(BookmarkGroup $bookmarkGroup): RedirectResponse
    {
        try {
            DB::transaction(function () use ($bookmarkGroup) {
                $bookmarkGroup->delete();

                Session::flash('success', 'The bookmark group was deleted successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.list'));
    }
}
