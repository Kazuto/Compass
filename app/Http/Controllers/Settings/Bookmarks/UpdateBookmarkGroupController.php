<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\UpdateBookmarkGroupAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookmarks\StoreBookmarkGroupRequest;
use App\Models\BookmarkGroup;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class UpdateBookmarkGroupController extends Controller
{
    public function __invoke(StoreBookmarkGroupRequest $request, BookmarkGroup $bookmarkGroup): RedirectResponse
    {
        return raid(
            'Update Bookmark Group',
            fn (Raid $raid) => $this->handle($request, $bookmarkGroup, $raid)
        );
    }

    private function handle(StoreBookmarkGroupRequest $request, BookmarkGroup $bookmarkGroup, Raid $raid): RedirectResponse
    {
        $raid
            ->addContext('bookmarkGroupId', $bookmarkGroup->id)
            ->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request, $bookmarkGroup, $raid) {
                $raid->debug('Calling Action', ['action' => UpdateBookmarkGroupAction::class]);

                app(UpdateBookmarkGroupAction::class)->execute($bookmarkGroup, $request->validated());

                $teamIds = collect($request->get('team_ids'))
                    ->filter(fn ($item) => (bool) $item)
                    ->keys();

                $raid->debug('Syncing Team IDs', ['teamIds' => $teamIds]);
                $bookmarkGroup->teams()->sync($teamIds);

                Session::flash('success', 'The bookmark group was updated successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));
    }
}
