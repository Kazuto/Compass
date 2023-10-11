<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Models\Bookmark;

class StoreBookmarkAction
{
    public function execute(array $data): Bookmark
    {
        return Bookmark::create($data);
    }
}
