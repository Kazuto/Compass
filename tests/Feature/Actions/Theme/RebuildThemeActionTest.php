<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Theme;

use App\Actions\Theme\RebuildThemeAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertStringNotContainsString;
use function PHPUnit\Framework\assertTrue;

beforeEach(function (): void {
    $this->testFile = sprintf('tests/tmp/%s-%s.json', now()->unix(), uniqid());
    File::copy('theme.config.example.json', $this->testFile);

    File::replace($this->testFile, json_encode($this->themeConfig(), JSON_PRETTY_PRINT));

    $this->config = File::get($this->testFile);
});

afterEach(function (): void {
    File::delete($this->testFile);
});

it('rebuilds the theme', function () {
    // Given
    $result = app(RebuildThemeAction::class)->execute();
    $oldStylesheet = $this->getStylesheet();

    // Then
    assertTrue($result);
    assertStringNotContainsString('.bg-accent-light{--tw-bg-opacity: 1;background-color:rgb(0 0 0 / var(--tw-bg-opacity))}', $oldStylesheet);
    assertStringContainsString('.bg-accent-light{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}', $oldStylesheet);

    // When
    $colors = Arr::dot($this->themeConfig());
    $colors['colors.accent.light'] = '#000000';
    $override = Arr::undot($colors);
    File::replace('theme.config.json', json_encode($override, JSON_PRETTY_PRINT));

    $result = app(RebuildThemeAction::class)->execute();
    $newStylesheet = $this->getStylesheet();

    // Then
    assertTrue($result);
    assertStringContainsString('.bg-accent-light{--tw-bg-opacity: 1;background-color:rgb(0 0 0 / var(--tw-bg-opacity))}', $newStylesheet);
    assertStringNotContainsString('.bg-accent-light{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}', $newStylesheet);
});
