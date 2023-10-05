<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonLink extends Component
{
    public function __construct(
        public string $href,
        public string $type = 'default',
    ) {
    }

    public function render(): View
    {
        return view('components.button-link');
    }
}
