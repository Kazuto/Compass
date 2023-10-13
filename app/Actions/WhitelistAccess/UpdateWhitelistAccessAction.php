<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Models\WhitelistAccess;

class UpdateWhitelistAccessAction
{
    public function execute(WhitelistAccess $whitelistAccess, array $data): bool
    {
        return $whitelistAccess->update($data);
    }
}
