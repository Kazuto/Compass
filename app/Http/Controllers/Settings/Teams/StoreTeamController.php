<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Teams;

use App\Actions\Teams\StoreTeamAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreTeamController extends Controller
{
    public function __invoke(StoreTeamRequest $request): RedirectResponse
    {
        return raid(
            'Store Team',
            fn (Raid $raid) => $this->handle($request, $raid),
        );
    }

    private function handle(StoreTeamRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request) {
                app(StoreTeamAction::class)->execute($request->validated());

                Session::flash('success', 'The team was added successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.teams.list'));
    }
}
