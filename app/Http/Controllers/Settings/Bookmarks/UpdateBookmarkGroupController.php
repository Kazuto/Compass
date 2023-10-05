<?php

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookmarkGroupRequest;
use App\Models\BookmarkGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class UpdateBookmarkGroupController extends Controller
{
    public function __invoke(StoreBookmarkGroupRequest $request, BookmarkGroup $bookmarkGroup): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $bookmarkGroup) {
                $bookmarkGroup->update($request->validated());

                Session::flash('success', 'The bookmark group was updated successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));
    }
}
