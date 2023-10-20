<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Actions\Teams\AddUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\AddUserRequest;
use App\Models\Team;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class AddUserController extends Controller
{
    public function __invoke(AddUserRequest $request, Team $team): RedirectResponse
    {
        return raid(
            'Adding a user to the team',
            fn (Raid $raid) => $this->handle($request, $team, $raid),
        );
    }

    private function handle(AddUserRequest $request, Team $team, Raid $raid): RedirectResponse
    {
        $raid->addContext('teamId', $team->id)
            ->addContext('userId', $request->get('user_id'));

        try {
            DB::transaction(function () use ($team, $request, $raid) {
                $raid->debug('Calling Action', ['action' => AddUserAction::class]);

                app(AddUserAction::class)->execute($team, (int) $request->get('user_id'));

                Session::flash('success', 'The user was added to the team successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.show', ['team' => $team]));
    }
}
