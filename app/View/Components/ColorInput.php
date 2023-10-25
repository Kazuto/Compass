<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ColorInput extends Component
{
    public function __construct(
        public string $id,
        public string $name,
        public string $value,
        public string $colorClass,
        public ?string $label = null
    ) {
    }

    public function render(): View
    {
        return view('components.color-input');
    }
}
