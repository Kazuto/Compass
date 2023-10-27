<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Actions\Action;
use App\Models\Team;
use LogicException;

class AddUserAction extends Action
{
    protected static string $description = 'Adding a user to a team';

    /**
     * @throws LogicException
     */
    public function execute(Team $team, int $userId): void
    {
        $team->users()->attach($userId);
    }
}
