<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BookmarkGroup;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('index', [
            'bookmarkGroups' => BookmarkGroup::all()->loadMissing('bookmarks'),
        ]);
    }
}
