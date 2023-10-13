<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Users;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // Given
    User::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('settings.users.list'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    User::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('settings.users.list'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('shows users', function () {
    // Given
    $users = User::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->get(route('settings.users.list'));

    // Then
    $response->assertStatus(Response::HTTP_OK);

    $users->each(function (User $user) use ($response) {
        $response->assertSee($user->name);
    });
});
