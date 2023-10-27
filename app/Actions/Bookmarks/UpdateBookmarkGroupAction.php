<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Actions\Action;
use App\Models\BookmarkGroup;

class UpdateBookmarkGroupAction extends Action
{
    public static string $description = 'Updating a bookmark group';

    public function execute(BookmarkGroup $bookmarkGroup, array $data): bool
    {
        return $bookmarkGroup->update($data);
    }
}
