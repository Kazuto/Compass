<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ToggleSwitch extends Component
{
    public function __construct(
        public string $id,
        public string $name,
        public string $label,
        public bool $value = false,
    ) {
    }

    public function render(): View
    {
        return view('components.toggle-switch');
    }
}
