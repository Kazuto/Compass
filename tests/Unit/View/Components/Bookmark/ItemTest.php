<?php

declare(strict_types=1);

namespace Tests\Unit\View\Components\Auth;

use App\Models\Bookmark;
use App\View\Components\Bookmark\Item;
use Illuminate\Testing\TestComponent;

it('shows bookmark name', function ($name) {
    // Given
    $bookmark = Bookmark::factory()->create([
        'name' => $name,
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(Item::class, [
        'bookmark' => $bookmark,
    ]);

    // Then
    $component->assertSee($name);
})->with([
    'Teams', 'Outlook', 'Word', 'Calendar', 'PowerPoint', 'OneNote',
]);

it('shows bookmark icon', function ($name, $icon) {
    // Given
    $bookmark = Bookmark::factory()->create([
        'name' => $name,
        'icon' => $icon,
    ]);

    // When
    /** @var TestComponent $component */
    $component = $this->component(Item::class, [
        'bookmark' => $bookmark,
    ]);

    // Then
    $component->assertSee($icon);
})->with([
    ['Laravel Documentation', '󰫐'],
    ['Laravel/Laravel', '󰊤'],
    ['AWS', '󰸏'],
    ['YouTube', ''],
]);
