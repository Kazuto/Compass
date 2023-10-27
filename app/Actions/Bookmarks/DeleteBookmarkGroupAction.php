<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Actions\Action;
use App\Models\BookmarkGroup;
use LogicException;

class DeleteBookmarkGroupAction extends Action
{
    protected static string $description = 'Deleting a bookmark group';

    /**
     * @throws LogicException
     */
    public function execute(BookmarkGroup $bookmarkGroup): bool
    {
        return $bookmarkGroup->delete();
    }
}
