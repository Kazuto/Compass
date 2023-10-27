<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Auth;

use App\Actions\User\OAuthUserAction;
use App\Models\Team;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseHas;
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
        ->assertRedirect(route('auth.index'))
        ->assertSessionHas('error', "The E-Mail assigned to your account is not whitelisted. \n\n Please talk to an administrator for access.");
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

it('syncs teams if whitelist access exists', function () {
    // Given
    WhitelistAccess::factory()
        ->has(Team::factory(3))
        ->create(['email' => $email = 'loren@ipsum.dolor']);

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
    assertDatabaseHas('team_user', ['team_id' => 1, 'user_id' => 1]);
    assertDatabaseHas('team_user', ['team_id' => 2, 'user_id' => 1]);
    assertDatabaseHas('team_user', ['team_id' => 3, 'user_id' => 1]);
});

it('does not update whitelist entry if account is active already', function () {
    // Given
    $this->mockSocialiteUser(email: $email = 'loren@ipsum.dolor');

    $user = User::factory()->create(['email' => $email]);
    $user->wasRecentlyCreated = false;

    $whitelistAccess = WhitelistAccess::factory()->for($user)->create(['email' => $email, 'is_active' => true]);

    $this->mockActionReturns(OAuthUserAction::class, $user);
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
