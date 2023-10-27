<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Actions\Action;
use App\Models\Team;

class StoreTeamAction extends Action
{
    protected static string $description = 'Creating a new team';

    public function execute(array $data): Team
    {
        return Team::create($data);
    }
}
