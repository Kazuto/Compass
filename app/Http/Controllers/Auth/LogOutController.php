<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Logging\Raid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogOutController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        return raid(
            'Log Out',
            fn (Raid $raid) => $this->handle(),
        );
    }

    private function handle(): RedirectResponse
    {
        Auth::logout();

        return to_route('auth.index');
    }
}
