<?php

declare(strict_types=1);

namespace App\Actions\Bookmarks;

use App\Models\Bookmark;

class UpdateBookmarkAction
{
    public function execute(Bookmark $bookmark, array $data): bool
    {
        return $bookmark->update($data);
    }
}
