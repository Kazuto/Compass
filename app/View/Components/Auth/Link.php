<?php

declare(strict_types=1);

namespace App\View\Components\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

use function route;
use function view;

class Link extends Component
{
    public bool $disabled = true;

    public function __construct(
        public string $provider,
        public string $icon = '',
    ) {
        $this->disabled = $this->checkDisabled();
    }

    public function render(): View
    {
        return view('components.auth.link');
    }

    public function redirectRoute(): string
    {
        return route('auth.redirect', ['provider' => $this->provider]);
    }

    private function checkDisabled(): bool
    {
        $config = config('services.'.$this->provider);

        return blank($config)
            || blank(Arr::get($config, 'client_id'))
            || blank(Arr::get($config, 'client_secret'))
            || blank(Arr::get($config, 'redirect'));
    }
}
