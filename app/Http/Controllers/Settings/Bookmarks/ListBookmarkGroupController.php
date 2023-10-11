<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use App\Models\BookmarkGroup;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function view;

class ListBookmarkGroupController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('settings.bookmarks.groups.index', [
            'bookmarkGroups' => BookmarkGroup::all()->loadMissing('bookmarks'),
        ]);
    }
}
