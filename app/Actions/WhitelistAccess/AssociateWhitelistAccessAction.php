<?php

declare(strict_types=1);

namespace App\Actions\WhitelistAccess;

use App\Models\User;
use App\Models\WhitelistAccess;

class AssociateWhitelistAccessAction
{
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
