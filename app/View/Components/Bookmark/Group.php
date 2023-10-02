<?php

declare(strict_types=1);

namespace App\View\Components\Bookmark;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use function view;

class Group extends Component
{
    public function __construct(
        public string $name,
    ) {
    }

    public function render(): View
    {
        return view('components.bookmark.group');
    }
}
