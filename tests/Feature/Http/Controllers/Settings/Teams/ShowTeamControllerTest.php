<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // Given
    $team = Team::factory()
        ->has(User::factory(5))
        ->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('settings.teams.show', ['team' => $team]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));
});

it('shows team', function () {
    // Given
    $team = Team::factory()
        ->has(User::factory(5))
        ->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('settings.teams.show', ['team' => $team]));

    // Then
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertSee($team->name)
        ->assertSeeInOrder($team->users->pluck('name')->toArray());
});
