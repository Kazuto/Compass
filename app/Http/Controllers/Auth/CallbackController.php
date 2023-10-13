<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\GitHubUserAction;
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

            return redirect(route('auth.index'));
        }

        $user = app(GitHubUserAction::class)->execute($authUser);

        $this->updateWhitelistAccess($user);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function updateWhitelistAccess(User $user): void
    {
        if (! $user->wasRecentlyCreated) {
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
