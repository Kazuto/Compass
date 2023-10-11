<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookmarkRequest;
use App\Models\Bookmark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class UpdateBookmarkController extends Controller
{
    public function __invoke(StoreBookmarkRequest $request, Bookmark $bookmark): RedirectResponse
    {
        // For redirection in case the group was changed
        $bookmarkGroup = $bookmark->bookmarkGroup;

        try {
            DB::transaction(function () use ($request, $bookmark) {
                $bookmark->update($request->validated());

                Session::flash('success', 'The bookmark was updated successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));
    }
}
