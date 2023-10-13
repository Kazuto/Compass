<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Models\Bookmark;
use LogicException;

class DeleteBookmarkAction
{
    /**
     * @throws LogicException
     */
    public function execute(Bookmark $bookmark): bool
    {
        return $bookmark->delete();
    }
}
