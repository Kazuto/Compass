<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Actions\Teams\AddUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\AddUserRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class AddUserController extends Controller
{
    public function __invoke(AddUserRequest $request, Team $team): RedirectResponse
    {
        try {
            DB::transaction(function () use ($team, $request) {
                app(AddUserAction::class)->execute($team, (int) $request->get('user_id'));

                Session::flash('success', 'The user was added to the team successfully.');
            });
        } catch (Throwable $e) {
            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.show', ['team' => $team]));
    }
}
