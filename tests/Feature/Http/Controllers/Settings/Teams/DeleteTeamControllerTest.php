<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\Teams\DeleteTeamAction;
use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertSoftDeleted;

it('redirects to login when unauthenticated', function () {
    // Given
    $team = Team::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->delete(route('settings.teams.delete', ['team' => $team]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    $team = Team::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->delete(route('settings.teams.delete', ['team' => $team]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('deletes the team and redirects', function () {
    // Given
    $team = Team::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->delete(route('settings.teams.delete', ['team' => $team]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.list'))
        ->assertSessionHas('success', 'The team was deleted successfully.');

    assertSoftDeleted('teams', ['id' => $team->id]);
});

it('catches exception and redirects with message', function () {
    // Given
    $team = Team::factory()->create();

    $this->mockActionThrows(DeleteTeamAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->delete(route('settings.teams.delete', ['team' => $team]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
