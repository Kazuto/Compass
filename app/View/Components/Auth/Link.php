<?php

declare(strict_types=1);

namespace App\View\Components\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use function route;
use function view;

class Link extends Component
{
    public function __construct(
        public string $provider,
        public string $icon = '',
        public bool $disabled = false,
    ) {
    }

    public function render(): View
    {
        return view('components.auth.link');
    }

    public function redirectRoute(): string
    {
        return route('auth.redirect', ['provider' => $this->provider]);
    }
}
