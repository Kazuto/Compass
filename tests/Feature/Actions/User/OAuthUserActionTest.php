<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\User;

use App\Actions\User\OAuthUserAction;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

it('creates new user', function () {
    // Given
    $this->mockSocialiteUser(
        name: 'John Doe',
        nickName: 'john-doe',
        email: fake()->safeEmail()
    );

    /** @var \Laravel\Socialite\Two\User $authUser */
    $authUser = Socialite::driver('github')->user();

    // When
    $user = app(OAuthUserAction::class)->execute($authUser, 'github');

    // Then
    assertTrue($user->wasRecentlyCreated);
    assertEquals($authUser->getName(), $user->name);
    assertEquals($authUser->getNickname(), $user->username);
    assertEquals($authUser->getEmail(), $user->email);
});

it('updates existing user', function () {
    // Given
    $this->mockSocialiteUser(
        name: 'John Doe',
        nickName: 'john-doe',
        email: fake()->safeEmail()
    );

    /** @var \Laravel\Socialite\Two\User $authUser */
    $authUser = Socialite::driver('github')->user();
    $authUser->setToken($token = fake()->md5());
    $authUser->setRefreshToken($refreshToken = fake()->md5());

    $user = User::factory()
        ->wasNotRecentlyCreated()
        ->create([
            'email' => $authUser->getEmail(),
            'oauth_id' => $authUser->getId(),
            'oauth_provider' => 'github',
        ]);

    $this->travel(5)->days();

    // When
    $response = app(OAuthUserAction::class)->execute($authUser, 'github');

    // Then
    assertEquals($response->email, $user->email);
    assertTrue($response->updated_at->isAfter($user->updated_at));
    assertEquals($token, $response->oauth_token);
    assertEquals($refreshToken, $response->oauth_refresh_token);
});

it('converts name to username if nickname not present', function () {
    // Given
    $this->mockSocialiteUser(
        name: 'John Doe',
        nickName: 'john-doe',
        email: fake()->safeEmail()
    );

    /** @var \Laravel\Socialite\Two\User $authUser */
    $authUser = Socialite::driver('github')->user();
    $authUser->setToken(fake()->md5());
    $authUser->setRefreshToken(fake()->md5());

    $this->travel(5)->days();

    // When
    $response = app(OAuthUserAction::class)->execute($authUser, 'github');

    // Then
    assertEquals('john-doe', $response->username);
});
