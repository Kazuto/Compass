<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\User;

use App\Actions\User\GitHubUserAction;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

it('creates new user', function () {
    // Given
    $this->mockSocialiteUser(email: fake()->safeEmail());

    /** @var \Laravel\Socialite\Two\User $authUser */
    $authUser = Socialite::driver('github')->user();

    // When
    $user = app(GitHubUserAction::class)->execute($authUser);

    assertTrue($user->wasRecentlyCreated);
    assertEquals($authUser->getName(), $user->name);
    assertEquals($authUser->getNickname(), $user->username);
    assertEquals($authUser->getEmail(), $user->email);
});

it('updates existing user', function () {
    // Given
    $this->mockSocialiteUser(email: fake()->safeEmail());

    /** @var \Laravel\Socialite\Two\User $authUser */
    $authUser = Socialite::driver('github')->user();
    $authUser->setToken($token = fake()->md5());
    $authUser->setRefreshToken($refreshToken = fake()->md5());

    $user = User::factory()
        ->wasNotRecentlyCreated()
        ->create([
            'email' => $authUser->getEmail(),
            'github_id' => $authUser->getId(),
        ]);

    $this->travel(5)->days();

    // When
    $response = app(GitHubUserAction::class)->execute($authUser);

    // Then
    assertEquals($response->email, $user->email);
    assertTrue($response->updated_at->isAfter($user->updated_at));
    assertEquals($token, $response->github_token);
    assertEquals($refreshToken, $response->github_refresh_token);
});
