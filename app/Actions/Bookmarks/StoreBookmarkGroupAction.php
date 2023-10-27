<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Actions\Action;
use App\Models\BookmarkGroup;

class StoreBookmarkGroupAction extends Action
{
    protected static string $description = 'Creating a new bookmark group';

    public function execute(array $data): BookmarkGroup
    {
        return BookmarkGroup::create($data);
    }
}
