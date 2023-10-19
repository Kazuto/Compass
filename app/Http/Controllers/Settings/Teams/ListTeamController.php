<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Support\Logging\Raid;
use Illuminate\View\View;
use Request;

use function view;

class ListTeamController extends Controller
{
    public function __invoke(Request $request): View
    {
        return raid(
            'List Teams',
            fn (Raid $raid) => $this->handle(),
        );
    }

    private function handle(): View
    {
        return view('settings.teams.index', [
            'teams' => Team::all()->loadMissing('users'),
        ]);
    }
}
