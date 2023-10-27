<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Models\WhitelistAccess;

class AssignTeamsToWhitelistAccessAction
{
    public function execute(WhitelistAccess $whitelistAccess, array $teamIds): WhitelistAccess
    {
        $whitelistAccess->teams()->sync($teamIds);

        return $whitelistAccess;
    }
}
