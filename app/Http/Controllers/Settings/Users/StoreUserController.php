<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Users;

use App\Actions\User\StoreUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class StoreUserController extends Controller
{
    public function __invoke(StoreUserRequest $request): RedirectResponse
    {
        return raid(
            'Create new User',
            fn (Raid $raid) => $this->handle($request, $raid),
        );
    }

    private function handle(StoreUserRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request, $raid) {
                $raid->debug('Calling Action', ['action' => StoreUserAction::class]);

                app(StoreUserAction::class)->execute($request->validated());

                Session::flash('success', 'The user was created successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.users.list'));
    }
}
