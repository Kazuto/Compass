<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings\Users;

use App\Actions\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user): RedirectResponse
    {
        return raid(
            'Updating User',
            fn (Raid $raid) => $this->handle($request, $user, $raid),
        );
    }

    private function handle(UpdateUserRequest $request, User $user, Raid $raid): RedirectResponse
    {
        $raid->addContext('userId', $user->id)->addContext('data', $request->validated());

        try {
            DB::transaction(function () use ($request, $user, $raid) {
                $raid->debug('Calling Action', ['action' => UpdateUserAction::class]);

                app(UpdateUserAction::class)->execute($user, $request->validated());

                Session::flash('success', 'The user was updated successfully.');
            });
        } catch (Throwable $e) {
            $raid->error('Exception occurred', ['exception' => $e->getMessage()]);

            Session::flash('error', 'Something went wrong!');
        }

        return redirect(route('settings.users.list'));
    }
}
