<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\WhitelistAccess;

use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // Given
    WhitelistAccess::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('settings.whitelist.list'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    WhitelistAccess::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('settings.whitelist.list'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('shows whitelist access entries', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory(5)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->get(route('settings.whitelist.list'));

    // Then
    $response->assertStatus(Response::HTTP_OK);

    $whitelistAccess->each(function (WhitelistAccess $whitelistAccess) use ($response) {
        $response->assertSee($whitelistAccess->email);
    });
});
