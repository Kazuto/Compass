<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use App\View\Components\Auth\Link;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\TestComponent;

it('disables provider login if config missing', function () {
    // Given
    Config::set('services.github');

    // When
    /** @var TestComponent $component */
    $component = $this->component(Link::class, [
        'provider' => 'github',
        'icon' => 'fab-github',
    ]);

    // Then
    $component->assertSee('Github (Disabled)');
});

it('enables provider login if config present', function () {
    // Given
    Config::set('services.github', [
        'client_id' => fake()->uuid(),
        'client_secrect' => fake()->uuid(),
        'redirect' => fake()->url(),
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(Link::class, [
        'provider' => 'github',
        'icon' => 'fab-github',
    ]);

    // Then
    $component->assertSee('Github');
});
