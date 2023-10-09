<?php

namespace Tests\Http\Controllers\Settings\Teams;

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

    $team->users()->attach($user);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.teams.remove-user', ['team' => $team]), [
            'user_id' => $user->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));

    assertNotEmpty($team->users);
    assertCount(1, $team->users);
});

it('add the user to the team and redirects', function () {
    // Given
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $team->users()->attach($user);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.teams.remove-user', ['team' => $team]), [
            'user_id' => $user->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.show', ['team' => $team]))
        ->assertSessionHas('success', 'The user was removed from the team successfully.');

    assertEmpty($team->users);
    assertCount(0, $team->users);
});
