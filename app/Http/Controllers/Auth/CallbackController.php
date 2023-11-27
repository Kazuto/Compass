<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SingleTenantAuthAction;
use App\Actions\Auth\WhitelistAuthAction;
use App\Exceptions\WhitelistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OAuthRequest;
use App\Models\User;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as OAuthUser;
use Throwable;

class CallbackController extends Controller
{
    private OAuthRequest $request;

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

        /** @var OAuthUser $authUser */
        $authUser = Socialite::driver($request->provider)->user();

        try {
            $user = match ($request->provider) {
                'microsoft' => $this->handleMicrosoft($authUser, $request),
                default => app(WhitelistAuthAction::class)->execute($authUser, $request->provider),
            };
        } catch (Throwable $e) {
            Session::flash('error', $e->getMessage());

            return to_route('auth.index');
        }

        Auth::login($user);

        Session::flash('success', "Welcome back, $user->name!");

        return to_route('dashboard');
    }

    /**
     * @throws WhitelistException
     */
    private function handleMicrosoft(OAuthUser $authUser, OAuthRequest $request): User
    {
        return match (config('services.microsoft.tenant')) {
            'common' => app(WhitelistAuthAction::class)->execute($authUser, $request->provider),
            default => app(SingleTenantAuthAction::class)->execute($authUser, $request->provider),
        };
    }
}
