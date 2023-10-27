<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Actions\Action;
use App\Models\User;
use App\Models\WhitelistAccess;

class AssociateWhitelistAccessAction extends Action
{
    protected static string $description = 'Associating Whitelist Access to User';

    public function execute(User $user): WhitelistAccess
    {
        $whitelistAccess = WhitelistAccess::forEmail($user->email)->first();
        $whitelistAccess->user()->associate($user);

        $whitelistAccess->update([
            'is_active' => true,
        ]);

        return $whitelistAccess;
    }
}
