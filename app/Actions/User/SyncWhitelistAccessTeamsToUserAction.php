<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;

class SyncWhitelistAccessTeamsToUserAction
{
    public function execute(User $user): User
    {
        $user->teams()->sync($user->whitelistAccess->teams()->pluck('id'));

        return $user;
    }
}
