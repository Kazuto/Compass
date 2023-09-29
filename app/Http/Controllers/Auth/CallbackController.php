<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(AuthRequest $request): RedirectResponse
    {
        /** @var \Laravel\Socialite\Two\User $authUser */
        $authUser = Socialite::driver($request->provider)->user();

        $user = User::updateOrCreate([
            'github_id' => $authUser->id,
        ], [
            'name' => $authUser->name,
            'email' => $authUser->email,
            'github_token' => $authUser->token,
            'github_refresh_token' => $authUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
