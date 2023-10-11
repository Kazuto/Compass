<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use App\View\Components\Bookmark\Group;
use Illuminate\Testing\TestComponent;

it('shows bookmark group name', function ($name) {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create([
        'name' => $name,
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(Group::class, [
        'bookmarkGroup' => $bookmarkGroup,
    ]);

    // Then
    $component->assertSee($name);
})->with(['Microsoft Office', 'Google Docs', 'GitHub Projects', 'Stack Overflow']);

it('shows bookmarks name', function ($name, $bookmarks) {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create([
        'name' => $name,
    ]);

    foreach ($bookmarks as $bookmark) {
        Bookmark::factory()->belongsToBookmarkGroup($bookmarkGroup)->create([
            'name' => $bookmark,
            'url' => fake()->url(),
        ]);
    }

    // When
    /** @var TestComponent $component */
    $component = $this->component(Group::class, [
        'bookmarkGroup' => $bookmarkGroup,
    ]);

    // Then
    $component->assertSeeInOrder($bookmarks);

    foreach ($bookmarks as $bookmark) {
        $component->assertSee($bookmark);
    }
})->with([
    ['Microsoft Office', ['Teams', 'Outlook', 'Word']],
    ['Google Docs', ['Google Drive', 'Google Sheets', 'Google Slides']],
    ['GitHub Projects', ['Laravel/Laravel', 'Laravel/Illuminate', 'Spatie/Once']],
]);
