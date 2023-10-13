<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Models\WhitelistAccess;

class StoreWhitelistAccessAction
{
    public function execute(array $data): WhitelistAccess
    {
        return WhitelistAccess::create($data);
    }
}
