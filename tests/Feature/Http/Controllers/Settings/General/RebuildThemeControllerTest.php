<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\Theme\RebuildThemeAction;
use App\Actions\Theme\UpdateThemeConfigAction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Testing\TestResponse;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function (): void {
    $this->tmpfile = tmpfile();

    fwrite($this->tmpfile, File::get('theme.config.example.json'));

    $metaData = stream_get_meta_data($this->tmpfile);
    $this->testFile = $metaData['uri'];
});

afterEach(function (): void {
    if (is_resource($this->tmpfile)) {
        fclose($this->tmpfile);
    }
});

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
});

it('updates theme and redirects', function () {
    // Given
    $colors = $this->themeConfig();

    $this->mockActionReturns(UpdateThemeConfigAction::class, $this->testFile, 'getConfigPath');

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

    $this->partialMock(UpdateThemeConfigAction::class, function (MockInterface $mock) {
        $mock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('execute')
            ->once()
            ->andThrows(Exception::class, 'Fun exception');

        $mock->shouldReceive('getConfigPath')->andReturn($this->testFile);
    });

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

    $this->mockActionReturns(UpdateThemeConfigAction::class, $this->testFile, 'getConfigPath');

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
