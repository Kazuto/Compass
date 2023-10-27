<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Actions\Action;
use App\Models\WhitelistAccess;

class AssignTeamsToWhitelistAccessAction extends Action
{
    protected static string $description = 'Assigning teams to whitelist access';

    public function execute(WhitelistAccess $whitelistAccess, array $teamIds): WhitelistAccess
    {
        $whitelistAccess->teams()->sync($teamIds);

        return $whitelistAccess;
    }
}
