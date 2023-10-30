<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Action;
use App\Actions\User\OAuthUserAction;
use App\Actions\User\SyncWhitelistAccessTeamsToUserAction;
use App\Actions\WhitelistAccess\AssociateWhitelistAccessAction;
use App\Exceptions\WhitelistException;
use App\Models\User;
use App\Models\WhitelistAccess;
use Laravel\Socialite\Two\User as OAuthUser;

class WhitelistAuthAction extends Action
{
    protected static string $description = 'Retrieving user by Whitelist Access';

    /**
     * @throws WhitelistException
     */
    public function execute(OAuthUser $authUser, string $provider): User
    {
        if (WhitelistAccess::isNotWhitelisted($authUser->getEmail())) {
            $this->raid->error('User not whitelisted', ['email' => $authUser->getEmail()]);

            throw WhitelistException::notFound();
        }

        $user = app(OAuthUserAction::class)->execute($authUser, $provider);

        $this->updateWhitelistAccess($user);

        return $user;
    }

    private function updateWhitelistAccess(User $user): void
    {
        $this->raid->debug('Updating Whitelist Access for User');

        if ($user->whitelistAccess()->active()->exists()) {
            $this->raid->debug('User already has whitelist access assigned. No need for update.');

            return;
        }

        app(AssociateWhitelistAccessAction::class)->execute($user);

        app(SyncWhitelistAccessTeamsToUserAction::class)->execute($user);

        $this->raid->debug('Whitelist Access updated for User');
    }
}
