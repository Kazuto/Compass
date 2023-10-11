<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Models\Team;
use LogicException;

class RemoveUserAction
{
    /**
     * @throws LogicException
     */
    public function execute(Team $team, int $userId): int
    {
        return $team->users()->detach($userId);
    }
}
