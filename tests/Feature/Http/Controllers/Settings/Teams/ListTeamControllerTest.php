<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Models\Team;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // Given
    Team::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('settings.teams.list'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('shows teams', function () {
    // Given
    $teams = Team::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('settings.teams.list'));

    // Then
    $response->assertStatus(Response::HTTP_OK);

    $teams->each(function (Team $team) use ($response) {
        $response->assertSee($team->name);
    });
});
