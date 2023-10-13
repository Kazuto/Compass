<?php

declare(strict_types=1);

namespace App\View\Components\Team;

use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public Team $team
    ) {
    }

    public function render(): View
    {
        return view('components.team.card');
    }
}
