<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Str;

class Modal extends Component
{
    public function __construct(
        public string $title,
        public ?string $id = null,
    ) {
        $this->id = $this->id ?? Str::slug($this->title);
    }

    public function render(): View
    {
        return view('components.modal');
    }
}
