<?php

declare(strict_types=1);

namespace App\View\Components\Auth;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Login extends Component
{
    public function __construct()
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.auth.login');
    }
}
