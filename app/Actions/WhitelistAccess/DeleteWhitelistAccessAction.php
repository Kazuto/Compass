<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Actions\Action;
use App\Models\WhitelistAccess;
use LogicException;

class DeleteWhitelistAccessAction extends Action
{
    protected static string $description = 'Deleting a whitelist access';

    /**
     * @throws LogicException
     */
    public function execute(WhitelistAccess $whitelistAccess): bool
    {
        return $whitelistAccess->delete();
    }
}
