<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Models\BookmarkGroup;

class UpdateBookmarkGroupAction
{
    public function execute(BookmarkGroup $bookmarkGroup, array $data): bool
    {
        return $bookmarkGroup->update($data);
    }
}
