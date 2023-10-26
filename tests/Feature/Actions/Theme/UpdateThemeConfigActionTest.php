<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Theme;

use App\Actions\Theme\UpdateThemeConfigAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;

beforeEach(function (): void {
    $this->testFile = sprintf('tests/tmp/%s-%s.json', now()->unix(), uniqid());

    File::copy('theme.config.example.json', $this->testFile);
});

afterEach(function (): void {
    File::delete($this->testFile);
});

it('updates theme config file', function () {
    // Given
    $oldColors = json_decode(File::get($this->testFile), true);

    // When
    $action = $this->partialMock(UpdateThemeConfigAction::class, function (MockInterface $mock) {
        $mock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getConfigPath')
            ->once()
            ->andReturns(app()->basePath($this->testFile));
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
