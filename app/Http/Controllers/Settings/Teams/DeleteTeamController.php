<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Actions\Teams\DeleteTeamAction;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class DeleteTeamController extends Controller
{
    public function __invoke(Team $team): RedirectResponse
    {
        return raid(
            'Deleting Team',
            fn (Raid $raid) => $this->handle($team, $raid),
        );
    }

    private function handle(Team $team, Raid $raid): RedirectResponse
    {
        $raid->addContext('teamId', $team->id);

        try {
            DB::transaction(function () use ($team) {
                app(DeleteTeamAction::class)->execute($team);

                Session::flash('success', 'The team was deleted successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.list'));
    }
}
