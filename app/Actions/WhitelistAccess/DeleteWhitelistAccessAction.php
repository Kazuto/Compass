<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Models\WhitelistAccess;
use LogicException;

class DeleteWhitelistAccessAction
{
    /**
     * @throws LogicException
     */
    public function execute(WhitelistAccess $whitelistAccess): bool
    {
        return $whitelistAccess->delete();
    }
}
