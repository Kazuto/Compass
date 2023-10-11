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

class StoreBookmarkController extends Controller
{
    public function __invoke(StoreBookmarkRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Bookmark::create($request->validated());

                Session::flash('success', 'The bookmark was added successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.list'));
    }
}
