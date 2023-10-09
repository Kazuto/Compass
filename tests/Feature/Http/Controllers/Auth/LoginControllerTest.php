<?php

namespace Tests\Http\Controllers\Auth;

use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('shows info text', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.login'));

    // Then
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertSessionHas('info', 'You need to be logged in to view this page.');
});

it('shows provider', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.login'));

    // Then
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertSee(['Github', 'Microsoft']);
});
