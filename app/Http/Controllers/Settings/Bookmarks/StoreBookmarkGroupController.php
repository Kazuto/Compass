<?php

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookmarkGroupRequest;
use App\Models\BookmarkGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreBookmarkGroupController extends Controller
{
    public function __invoke(StoreBookmarkGroupRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                BookmarkGroup::create($request->validated());

                Session::flash('success', 'The bookmark group was added successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.list'));
    }
}
