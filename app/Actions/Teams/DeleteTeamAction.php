<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Models\Team;
use LogicException;

class DeleteTeamAction
{
    /**
     * @throws LogicException
     */
    public function execute(Team $team): bool
    {
        return $team->delete();
    }
}
