<?php

namespace App\Http\Controllers\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\RemoveUserRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class RemoveUserController extends Controller
{
    public function __invoke(RemoveUserRequest $request, Team $team): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $team) {
                $team->users()->detach($request->get('user_id'));

                Session::flash('success', 'The user was removed from the team successfully.');
            });
        } catch (Throwable) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.show', ['team' => $team]));
    }
}
