<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Theme;

use App\Actions\Theme\RebuildThemeAction;
use App\Exceptions\CommandException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertTrue;

beforeEach(function (): void {
    $oldFile = $this->getStylesheetPath();

    if (File::exists($oldFile)) {
        File::delete($oldFile);
    }
});

it('rebuilds the theme with correct colors', function () {
    // Given
    assertTrue(File::missing($this->getStylesheetPath()));

    // When
    $result = app(RebuildThemeAction::class)->execute();
    $newFile = $this->getStylesheetPath();

    // Then
    assertTrue($result);
    assertTrue(File::exists($newFile));

    tap(File::get($newFile), function (string $newStylesheet) {
        assertStringContainsString('.bg-accent-light{--tw-bg-opacity: 1;background-color:rgb(255 202 122 / var(--tw-bg-opacity))}', $newStylesheet);
        assertStringContainsString('.bg-accent-medium{--tw-bg-opacity: 1;background-color:rgb(255 153 0 / var(--tw-bg-opacity))}', $newStylesheet);
        assertStringContainsString('.bg-accent-dark{--tw-bg-opacity: 1;background-color:rgb(179 107 0 / var(--tw-bg-opacity))}', $newStylesheet);
        assertStringContainsString('.bg-base-light{--tw-bg-opacity: 1;background-color:rgb(242 246 250 / var(--tw-bg-opacity))}', $newStylesheet);
        assertStringContainsString('.bg-base-medium{--tw-bg-opacity: 1;background-color:rgb(67 123 174 / var(--tw-bg-opacity))}', $newStylesheet);
        assertStringContainsString('.bg-base-dark{--tw-bg-opacity: 1;background-color:rgb(20 37 52 / var(--tw-bg-opacity))}', $newStylesheet);
    });
});

it('throws exception if unsuccessful', function () {
    Process::fake([
        '*' => Process::result(
            output: 'Test output',
            errorOutput: 'Test error output',
            exitCode: 1,
        ),
    ]);

    // When
    app(RebuildThemeAction::class)->execute();
})
    ->throws(CommandException::class, 'The command did not execute successfully.');
