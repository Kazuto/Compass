<?php

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\View\View;
use Request;

use function view;

class ShowTeamController extends Controller
{
    public function __invoke(Request $request, Team $team): View
    {
        return view('settings.teams.show', [
            'team' => $team->loadMissing([
                'users',
                'bookmarkGroups.bookmarks',
            ]),
        ]);
    }
}
