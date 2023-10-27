<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Actions\Action;
use App\Models\Team;
use LogicException;

class DeleteTeamAction extends Action
{
    protected static string $description = 'Deleting a team';

    /**
     * @throws LogicException
     */
    public function execute(Team $team): bool
    {
        return $team->delete();
    }
}
