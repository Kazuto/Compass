<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Auth;

use App\Actions\User\GitHubUserAction;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

it('redirects to login when email not whitelisted', function () {
    // Given
    $this->mockSocialiteUser();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'))
        ->assertSessionHas('error', "The E-Mail assigned to your account is not whitelisted. \n\n Please talk to an administrator for access.");
});

it('creates whitelist entry if logged in as admin', function () {
    // Given
    Config::set('compass.auth.whitelist_admin_email', $email = 'loren@ipsum.dolor');
    $this->mockSocialiteUser(email: $email);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseHas('whitelist_access', ['email' => $email]);
});

it('does not create whitelist entry if admin account exists already', function () {
    // Given
    Config::set('compass.auth.whitelist_admin_email', $email = 'loren@ipsum.dolor');
    $this->mockSocialiteUser(email: $email);

    $user = User::factory()->create(['email' => $email]);
    $user->wasRecentlyCreated = false;

    $this->mockActionReturns(GitHubUserAction::class, $user);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseMissing('whitelist_access', ['email' => $email]);
});

it('does not update whitelist entry if account exists already', function () {
    // Given
    $this->mockSocialiteUser(email: $email = 'loren@ipsum.dolor');

    $user = User::factory()->create(['email' => $email]);
    $user->wasRecentlyCreated = false;

    $whitelistAccess = WhitelistAccess::factory()->create(['email' => $email]);

    $this->mockActionReturns(GitHubUserAction::class, $user);
    $this->travel(5)->days();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseHas('whitelist_access', ['email' => $email]);
    tap((clone $whitelistAccess)->refresh(), function ($dbRecord) use ($whitelistAccess) {
        assertEquals($whitelistAccess->email, $dbRecord->email);
        assertTrue($whitelistAccess->updated_at->equalTo($dbRecord->updated_at));
    });
});

it('authenticates if whitelist access entry exists', function () {
    // Given
    WhitelistAccess::factory()->create(['email' => $email = 'loren@ipsum.dolor']);
    $this->mockSocialiteUser(email: $email);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseHas('whitelist_access', ['email' => $email, 'is_active' => true]);
});
