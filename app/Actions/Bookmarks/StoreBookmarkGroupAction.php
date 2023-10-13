<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Models\BookmarkGroup;

class StoreBookmarkGroupAction
{
    public function execute(array $data): BookmarkGroup
    {
        return BookmarkGroup::create($data);
    }
}
