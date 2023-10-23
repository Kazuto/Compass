<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogInRequest;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogInController extends Controller
{
    public function __invoke(LogInRequest $request): RedirectResponse
    {
        return raid(
            'Basic Auth - Log In',
            fn (Raid $raid) => $this->handle($request),
        );
    }

    private function handle(LogInRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            $user = Auth::user();

            Session::flash('success', "Welcome back, $user->name!");

            return to_route('dashboard');
        }

        Session::flash('error', 'Invalid username or password.');

        return to_route('auth.index');
    }
}
