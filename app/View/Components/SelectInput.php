<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public function __construct(
        public string $id,
        public string $name,
        public Collection $options,
        public string $optionValue = 'id',
        public string $optionLabel = 'name',
        public ?string $label = null,
    ) {
        $this->label = $this->label ?? Str::title($this->name);
    }

    public function render(): View
    {
        return view('components.select-input');
    }
}
