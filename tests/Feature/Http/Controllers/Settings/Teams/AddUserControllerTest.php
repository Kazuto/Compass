<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\Teams\AddUserAction;
use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertNotEmpty;

it('redirects to login when unauthenticated', function () {
    // Given
    $user = User::factory()->create();
    $team = Team::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.teams.add-user', ['team' => $team]), [
            'user_id' => $user->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));

    assertEmpty($team->users);
    assertCount(0, $team->users);
});

it('redirects to dashboard if not admin', function () {
    // Given
    $user = User::factory()->create();
    $team = Team::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.teams.add-user', ['team' => $team]), [
            'user_id' => $user->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertEmpty($team->users);
    assertCount(0, $team->users);
});

it('add the user to the team and redirects', function () {
    // Given
    $user = User::factory()->create();
    $team = Team::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.teams.add-user', ['team' => $team]), [
            'user_id' => $user->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.show', ['team' => $team]))
        ->assertSessionHas('success', 'The user was added to the team successfully.');

    assertNotEmpty($team->users);
    assertCount(1, $team->users);
});

it('catches exception and redirects with message', function () {
    // Given
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $this->mockActionThrows(AddUserAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.teams.add-user', ['team' => $team]), [
            'user_id' => $user->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.show', ['team' => $team]))
        ->assertSessionHas('error', 'Something went wrong!');
});
