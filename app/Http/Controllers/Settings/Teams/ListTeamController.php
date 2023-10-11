<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\View\View;
use Request;

use function view;

class ListTeamController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('settings.teams.index', ['teams' => Team::all()->loadMissing('users')]);
    }
}
