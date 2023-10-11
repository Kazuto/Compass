<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\UpdateBookmarkGroupAction;
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
                app(UpdateBookmarkGroupAction::class)->execute($bookmarkGroup, $request->validated());

                $bookmarkGroup->teams()->sync($request->get('team_ids'));

                Session::flash('success', 'The bookmark group was updated successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));
    }
}
