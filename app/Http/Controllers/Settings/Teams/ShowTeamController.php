<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Support\Logging\Raid;
use Illuminate\View\View;
use Illuminate\Support\Facades\Request;

use function view;

class ShowTeamController extends Controller
{
    public function __invoke(Request $request, Team $team): View
    {
        return raid(
            'Show Team',
            fn (Raid $raid) => $this->handle($team, $raid),
        );
    }

    private function handle(Team $team, Raid $raid): View
    {
        $raid->addContext('teamId', $team->id);

        return view('settings.teams.show', [
            'team' => $team->loadMissing(['users', 'bookmarkGroups.bookmarks']),
            'users' => User::whereNotIn('id', $team->users->pluck('id'))->get(),
        ]);
    }
}
