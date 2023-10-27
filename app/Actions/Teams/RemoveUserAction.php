<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Actions\Action;
use App\Models\Team;
use LogicException;

class RemoveUserAction extends Action
{
    protected static string $description = 'Removing a user from a team';

    /**
     * @throws LogicException
     */
    public function execute(Team $team, int $userId): int
    {
        return $team->users()->detach($userId);
    }
}
