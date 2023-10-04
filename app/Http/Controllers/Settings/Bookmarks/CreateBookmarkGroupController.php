<?php

namespace App\Http\Controllers\Settings\Bookmarks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function view;

class CreateBookmarkGroupController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('settings.bookmarks.groups.create');
    }
}
