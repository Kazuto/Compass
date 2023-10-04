<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public string $type = 'success'
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
