<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class TextInput extends Component
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $type = 'text',
        public ?string $label = null,
        public ?string $value = null,
    ) {
        $this->label = $this->label ?? Str::title($this->name);
    }

    public function render(): View
    {
        return view('components.text-input');
    }
}
