<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Action;
use App\Models\User;

class SyncWhitelistAccessTeamsToUserAction extends Action
{
    protected static string $description = 'Syncing teams from whitelist access to user';

    public function execute(User $user): User
    {
        $user->teams()->sync($user->whitelistAccess->teams()->pluck('id'));

        return $user;
    }
}
