<?php

declare(strict_types=1);

namespace App\View\Components\Bookmark;

use App\Models\BookmarkGroup;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use function view;

class GroupCard extends Component
{
    public function __construct(
        public BookmarkGroup $bookmarkGroup
    ) {
    }

    public function render(): View
    {
        return view('components.bookmark.group-card');
    }
}
