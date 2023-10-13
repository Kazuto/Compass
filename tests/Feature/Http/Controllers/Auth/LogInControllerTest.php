<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when invalid credentials', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('auth.login', ['username' => fake()->username(), 'password' => fake()->password()]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'))
        ->assertSessionHas('error', 'Invalid username or password.');
});

it('authenticates if credentials are correct', function () {
    // Given
    User::factory()->create([
        'username' => $username = 'randomUser',
        'password' => bcrypt('password'),
    ]);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('auth.login', ['username' => $username, 'password' => 'password']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});
