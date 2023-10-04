<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $id,
        public string $title,
        public string $buttonText = 'Open',
        public string $buttonType = ''
    ) {
    }

    public function render(): View
    {
        return view('components.modal');
    }
}
