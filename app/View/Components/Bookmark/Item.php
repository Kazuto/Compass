<?php

declare(strict_types=1);

namespace App\View\Components\Bookmark;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use function view;

class Item extends Component
{
    public function __construct(
        public string $name,
        public string $url,
        public string $icon = '',
    ) {
    }

    public function render(): View
    {
        return view('components.bookmark.item');
    }
}
