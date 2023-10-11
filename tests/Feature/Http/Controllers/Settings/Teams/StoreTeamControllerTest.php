<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\Teams\StoreTeamAction;
use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

it('redirects to login when unauthenticated', function () {
    // Given
    $team = Team::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.teams.store'), $team->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));

    assertDatabaseEmpty('teams');
});

it('creates the team and redirects', function () {
    // Given
    $team = Team::factory()->make()->withoutRelations()->toArray();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.teams.store'), $team);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.list'))
        ->assertSessionHas('success', 'The team was added successfully.');

    assertDatabaseHas('teams', $team);
});

it('catches exception and redirects with message', function () {
    // Given
    $team = Team::factory()->make()->withoutRelations()->toArray();

    $this->mockActionThrows(StoreTeamAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.teams.store'), $team);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.teams.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
