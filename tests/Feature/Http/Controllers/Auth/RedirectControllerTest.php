<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Auth;

use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to provider', function ($provider, $redirectUrl) {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.redirect', ['provider' => $provider]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirectContains($redirectUrl);
})->with([
    ['github', 'https://github.com/login/oauth/authorize'],
]);
