<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\GitHubUserAction;
use App\Actions\WhitelistAccess\StoreWhitelistAccessAction;
use App\Actions\WhitelistAccess\UpdateWhitelistAccessAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Session;

class CallbackController extends Controller
{
    public function __invoke(AuthRequest $request): RedirectResponse
    {
        /** @var \Laravel\Socialite\Two\User $authUser */
        $authUser = Socialite::driver($request->provider)->user();

        if (WhitelistAccess::isNotWhitelisted($authUser->getEmail())) {
            Session::flash('error', "The E-Mail assigned to your account is not whitelisted. \n\n Please talk to an administrator for access.");

            return redirect(route('auth.login'));
        }

        $user = app(GitHubUserAction::class)->execute($authUser);

        $this->updateOrCreateWhitelistAccess($user);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function updateOrCreateWhitelistAccess(User $user): void
    {
        if (! $user->wasRecentlyCreated) {
            return;
        }

        if ($user->email === config('compass.auth.whitelist_admin_email')) {
            app(StoreWhitelistAccessAction::class)->execute([
                'email' => $user->email,
                'user_id' => $user->id,
                'is_active' => true,
            ]);

            return;
        }

        app(UpdateWhitelistAccessAction::class)->execute(
            WhitelistAccess::forEmail($user->email)->first(),
            [
                'user_id' => $user->id,
                'is_active' => true,
            ]
        );
    }
}
