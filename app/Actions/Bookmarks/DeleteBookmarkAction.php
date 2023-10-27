<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Actions\Action;
use App\Models\Bookmark;
use LogicException;

class DeleteBookmarkAction extends Action
{
    protected static string $description = 'Deleting a bookmark';

    /**
     * @throws LogicException
     */
    public function execute(Bookmark $bookmark): bool
    {
        return $bookmark->delete();
    }
}
