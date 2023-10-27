<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Actions\Action;
use App\Models\Bookmark;

class StoreBookmarkAction extends Action
{
    protected static string $description = 'Creating a new bookmark';

    public function execute(array $data): Bookmark
    {
        return Bookmark::create($data);
    }
}
