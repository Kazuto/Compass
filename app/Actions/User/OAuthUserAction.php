<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Action;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\User as SocialiteUser;

class OAuthUserAction extends Action
{
    protected static string $description = 'Creating or updating a user from OAuth provider';

    private string $provider;

    public function execute(SocialiteUser $socialiteUser, string $provider): User
    {
        $this->provider = $provider;

        $user = $this->findUser($socialiteUser);

        if (! $user->wasRecentlyCreated) {
            $this->updateUser($user, $socialiteUser);
        }

        return $user;
    }

    private function findUser(SocialiteUser $socialiteUser): User
    {
        return User::firstOrCreate([
            'oauth_provider' => $this->provider,
            'oauth_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName(),
            'username' => $this->getUsername($socialiteUser),
            'email' => $socialiteUser->getEmail(),
            'oauth_token' => $socialiteUser->token,
            'oauth_refresh_token' => $socialiteUser->refreshToken,
        ]);
    }

    private function updateUser(User $user, SocialiteUser $socialiteUser): void
    {
        $user->update([
            'oauth_token' => $socialiteUser->token,
            'oauth_refresh_token' => $socialiteUser->refreshToken,
        ]);
    }

    private function getUsername(SocialiteUser $socialiteUser): string
    {
        $nickname = $socialiteUser->getNickname();

        if (filled($nickname)) {
            return $nickname;
        }

        return Str::slug($socialiteUser->getName());
    }
}
