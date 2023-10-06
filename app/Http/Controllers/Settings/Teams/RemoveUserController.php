<?php

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class RemoveUserController extends Controller
{
    public function __invoke(Team $team, User $user): RedirectResponse
    {
        try {
            DB::transaction(function () use ($team, $user) {
                $team->users()->detach($user);

                Session::flash('success', 'The user was removed from the team successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.show', ['team' => $team]));
    }
}
