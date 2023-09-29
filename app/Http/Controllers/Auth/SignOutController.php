<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        if (filled(Auth::user())) {
            Auth::logout();
        }

        return redirect()->route('compass.home');
    }
}
