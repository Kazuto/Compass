<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\WhitelistAccess;

use App\Actions\Theme\LoadThemeConfigAction;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('settings.general.index'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('settings.general.index'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('shows general settings', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->get(route('settings.general.index'));

    // Then
    $response->assertStatus(Response::HTTP_OK);

    $response->assertSee(config('compass.version'));
});

it('throws exception if theme config missing', function () {
    // Given
    $this->mockActionThrows(LoadThemeConfigAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->get(route('settings.general.index'));

    // Then
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertSessionHas('error', 'Error loading theme config!');
});
