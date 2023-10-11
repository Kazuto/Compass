<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Models\BookmarkGroup;
use LogicException;

class DeleteBookmarkGroupAction
{
    /**
     * @throws LogicException
     */
    public function execute(BookmarkGroup $bookmarkGroup): bool
    {
        return $bookmarkGroup->delete();
    }
}
