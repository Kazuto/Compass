<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteTeamController extends Controller
{
    public function __invoke(Team $team): RedirectResponse
    {
        try {
            DB::transaction(function () use ($team) {
                $team->delete();

                Session::flash('success', 'The team was deleted successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.list'));
    }
}
