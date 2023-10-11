<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Models\Team;

class StoreTeamAction
{
    public function execute(array $data): Team
    {
        return Team::create($data);
    }
}
