<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Models\BookmarkGroup;
use App\Support\Logging\Raid;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function view;

class ShowBookmarkGroupController extends Controller
{
    public function __invoke(Request $request, BookmarkGroup $bookmarkGroup): View
    {
        return raid(
            'Show Bookmark Group',
            fn (Raid $raid) => $this->handle($bookmarkGroup, $raid)
        );
    }

    private function handle(BookmarkGroup $bookmarkGroup, Raid $raid): View
    {
        $raid->addContext('bookmarkGroupId', $bookmarkGroup->id);

        return view('settings.bookmarks.groups.show', [
            'bookmarkGroup' => $bookmarkGroup->load(['bookmarks', 'teams.users']),
            'bookmarkGroups' => BookmarkGroup::all(),
        ]);
    }
}
