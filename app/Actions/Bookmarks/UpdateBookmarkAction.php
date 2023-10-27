<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Actions\Action;
use App\Models\Bookmark;

class UpdateBookmarkAction extends Action
{
    public static string $description = 'Updating a bookmark';

    public function execute(Bookmark $bookmark, array $data): bool
    {
        return $bookmark->update($data);
    }
}
