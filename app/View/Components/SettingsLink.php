<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class SettingsLink extends Component
{
    public function __construct(
        public string $route,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.settings-link');
    }

    public function activeRoutePattern(): string
    {
        $segments = Str::of($this->route)->explode('.');

        $segments->pop();

        return $segments->add('*')->join('.');
    }

    public function isActive()
    {
        return request()->routeIs($this->activeRoutePattern());
    }
}
