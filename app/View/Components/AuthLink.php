<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthLink extends Component
{
    public function __construct(
        public string $provider
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.auth-link');
    }

    public function redirectRoute(): string
    {
        return route('auth.redirect', ['provider' => $this->provider]);
    }
}
