<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\OAuthUserAction;
use App\Actions\WhitelistAccess\UpdateWhitelistAccessAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OAuthRequest;
use App\Models\User;
use App\Models\WhitelistAccess;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(OAuthRequest $request): RedirectResponse
    {
        return raid(
            'OAuth Callback',
            fn (Raid $raid) => $this->handle($request, $raid),
        );
    }

    private function handle(OAuthRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('provider', $request->provider);

        /** @var \Laravel\Socialite\Two\User $authUser */
        $authUser = Socialite::driver($request->provider)->user();

        if (WhitelistAccess::isNotWhitelisted($authUser->getEmail())) {
            $raid->info('User not whitelisted', ['email' => $authUser->getEmail()]);

            Session::flash('error', "The E-Mail assigned to your account is not whitelisted. \n\n Please talk to an administrator for access.");

            return redirect(route('auth.index'));
        }

        $raid->debug('Calling Action', ['action' => OAuthUserAction::class]);

        $user = app(OAuthUserAction::class)->execute($authUser, $request->provider);

        $raid->debug('User fetched', ['userId' => $user->id]);

        $this->updateWhitelistAccess($user, $raid);

        Auth::login($user);

        $raid->info('User authenticated.');

        return to_route('dashboard');
    }

    private function updateWhitelistAccess(User $user, Raid $raid): void
    {
        $raid->debug('Updating Whitelist Access for User');

        if (! $user->wasRecentlyCreated) {
            $raid->debug('User was not created recently. No need for update.');

            return;
        }

        $raid->debug('Calling Action', ['action' => UpdateWhitelistAccessAction::class]);

        app(UpdateWhitelistAccessAction::class)->execute(
            WhitelistAccess::forEmail($user->email)->first(),
            [
                'user_id' => $user->id,
                'is_active' => true,
            ]
        );

        $raid->debug('Whitelist Access updated for User');
    }
}
