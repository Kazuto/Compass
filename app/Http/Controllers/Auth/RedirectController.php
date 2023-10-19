<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OAuthRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class RedirectController extends Controller
{
    public function __invoke(OAuthRequest $request): RedirectResponse
    {
        return raid(
            'OAuth Redirect',
            fn (Raid $raid) => $this->handle($request, $raid),
        );
    }

    private function handle(OAuthRequest $request, Raid $raid): RedirectResponse
    {
        $raid->addContext('provider', $request->provider);

        return Socialite::driver($request->provider)->redirect();
    }
}
