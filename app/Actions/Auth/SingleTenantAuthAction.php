<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Action;
use App\Actions\User\OAuthUserAction;
use App\Models\User;
use Laravel\Socialite\Two\User as OAuthUser;

class SingleTenantAuthAction extends Action
{
    protected static string $description = 'Retrieving user by microsoft single tenant';

    public function execute(OAuthUser $authUser, string $provider): User
    {
        return app(OAuthUserAction::class)->execute($authUser, $provider);
    }
}
