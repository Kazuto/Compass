<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Laravel\Socialite\Two\User as SocialiteUser;

class GitHubUserAction
{
    public function execute(SocialiteUser $socialiteUser): User
    {
        $user = $this->findUser($socialiteUser);

        if (! $user->wasRecentlyCreated) {
            $this->updateUser($user, $socialiteUser);
        }

        return $user;
    }

    private function findUser(SocialiteUser $socialiteUser): User
    {
        return User::firstOrCreate([
            'github_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName(),
            'username' => $socialiteUser->getNickname(),
            'email' => $socialiteUser->getEmail(),
            'github_token' => $socialiteUser->token,
            'github_refresh_token' => $socialiteUser->refreshToken,
        ]);
    }

    private function updateUser(User $user, SocialiteUser $socialiteUser): void
    {
        $user->update([
            'github_token' => $socialiteUser->token,
            'github_refresh_token' => $socialiteUser->refreshToken,
        ]);
    }
}
