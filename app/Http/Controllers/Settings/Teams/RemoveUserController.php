<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Actions\Teams\RemoveUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\RemoveUserRequest;
use App\Models\Team;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class RemoveUserController extends Controller
{
    public function __invoke(RemoveUserRequest $request, Team $team): RedirectResponse
    {
        return raid(
            'Remove a user from the team',
            fn (Raid $raid) => $this->handle($raid, $request, $team)
        );
    }

    private function handle(Raid $raid, RemoveUserRequest $request, Team $team): RedirectResponse
    {
        $raid->addContext('teamId', $team->id)
            ->addContext('userId', $request->get('user_id'));

        try {
            DB::transaction(function () use ($request, $team) {
                app(RemoveUserAction::class)->execute($team, $request->get('user_id'));

                Session::flash('success', 'The user was removed from the team successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.show', ['team' => $team]));
    }
}
