<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Actions\Action;
use App\Models\WhitelistAccess;

class StoreWhitelistAccessAction extends Action
{
    protected static string $description = 'Creating a new whitelist access';

    public function execute(array $data): WhitelistAccess
    {
        return WhitelistAccess::create($data);
    }
}
