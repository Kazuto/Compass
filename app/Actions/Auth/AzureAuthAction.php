<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Action;
use App\Actions\User\OAuthUserAction;
use App\Models\User;
use Laravel\Socialite\Two\User as OAuthUser;

class AzureAuthAction extends Action
{
    protected static string $description = 'Retrieving user by Azure domain';

    public function execute(OAuthUser $authUser, string $provider): User
    {
        return app(OAuthUserAction::class)->execute($authUser, $provider);
    }
}
