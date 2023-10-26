<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\Theme\RebuildThemeAction;
use App\Actions\Theme\UpdateThemeConfigAction;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseEmpty;

it('redirects to login when unauthenticated', function () {
    // Given
    $colors = $this->themeConfig();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.general.rebuild-theme'), $colors);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    $colors = $this->themeConfig();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.general.rebuild-theme'), $colors);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseEmpty('whitelist_access');
});

it('updates theme access entry and redirects', function () {
    // Given
    $colors = $this->themeConfig();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.general.rebuild-theme'), $colors);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.general.index'))
        ->assertSessionHas('success', 'Your theme has been rebuilt.');
});

it('catches exception when config not saved and redirects with message', function () {
    // Given
    $colors = $this->themeConfig();

    $this->mockActionThrows(UpdateThemeConfigAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.general.rebuild-theme'), $colors);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.general.index'))
        ->assertSessionHas('error', 'There was a problem saving the configuration.');
});

it('catches exception when theme not rebuilt and redirects with message', function () {
    // Given
    $colors = $this->themeConfig();

    $this->mockActionThrows(RebuildThemeAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.general.rebuild-theme'), $colors);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.general.index'))
        ->assertSessionHas('error', 'There was a problem rebuilding the theme.');
});
