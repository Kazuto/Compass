<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Models\Team;
use LogicException;

class AddUserAction
{
    /**
     * @throws LogicException
     */
    public function execute(Team $team, int $userId): void
    {
        $team->users()->attach($userId);
    }
}
