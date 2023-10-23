<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::user()->is_admin) {
            return $request->expectsJson()
                ? abort(403)
                : redirect()->route('dashboard');
        }

        return $next($request);
    }
}
