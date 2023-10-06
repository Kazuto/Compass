<?php

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
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
            'users' => User::whereNotIn('id', $team->users->pluck('id'))->get(),
        ]);
    }
}
