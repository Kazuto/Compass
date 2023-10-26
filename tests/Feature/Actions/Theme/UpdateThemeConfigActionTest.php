<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Theme;

use App\Actions\Theme\UpdateThemeConfigAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertTrue;

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

it('returns correct theme config file path', function () {
    // When
    $response = $this->invokeMethod(app(UpdateThemeConfigAction::class), 'getConfigPath', []);

    // Then
    assertEquals(app()->basePath('theme.config.json'), $response);
});

it('returns correct theme config example file path', function () {
    // When
    $response = $this->invokeMethod(app(UpdateThemeConfigAction::class), 'getConfigExamplePath', []);

    // Then
    assertEquals(app()->basePath('theme.config.example.json'), $response);
});

it('copies example file if theme config file is missing', function () {
    // Given
    fclose($this->tmpfile);
    assertTrue(File::missing($this->testFile));

    // When
    $action = $this->partialMock(UpdateThemeConfigAction::class, function (MockInterface $mock) {
        $mock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getConfigPath')
            ->once()
            ->andReturns($this->testFile);

        $mock->shouldReceive('getConfigExamplePath')
            ->once()
            ->andReturns('theme.config.example.json');
    });

    $action->execute($this->themeConfig());

    // Then
    assertTrue(File::exists($this->testFile));
});

it('updates theme config file', function () {
    // Given
    $oldColors = json_decode(File::get($this->testFile), true);

    // When
    $action = $this->partialMock(UpdateThemeConfigAction::class, function (MockInterface $mock) {
        $mock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getConfigPath')
            ->once()
            ->andReturns($this->testFile);
    });

    $action->execute($this->themeConfig());

    $newColors = json_decode(File::get($this->testFile), true);

    // Then
    assertNotEquals($oldColors, $newColors);
    assertEquals(Arr::get($newColors, 'colors.accent.light'), Arr::get($this->themeConfig(), 'colors.accent.light'));
    assertEquals(Arr::get($newColors, 'colors.accent.medium'), Arr::get($this->themeConfig(), 'colors.accent.medium'));
    assertEquals(Arr::get($newColors, 'colors.accent.dark'), Arr::get($this->themeConfig(), 'colors.accent.dark'));
    assertEquals(Arr::get($newColors, 'colors.base.light'), Arr::get($this->themeConfig(), 'colors.base.light'));
    assertEquals(Arr::get($newColors, 'colors.base.medium'), Arr::get($this->themeConfig(), 'colors.base.medium'));
    assertEquals(Arr::get($newColors, 'colors.base.dark'), Arr::get($this->themeConfig(), 'colors.base.dark'));
});
