<?php

namespace Tests\Unit\Models;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has bookmark group relation and returns model', function () {
    // When
    $bookmark = Bookmark::factory()->create();

    // Then
    assertTrue($bookmark->isRelation('bookmarkGroup'));
    assertInstanceOf(BookmarkGroup::class, $bookmark->bookmarkGroup);
});

it('returns bookmarks sorted by column "order"', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create();

    $data = [
        'name' => fake()->name(),
        'url' => fake()->url(),
        'icon' => '',
        'bookmark_group_id' => $bookmarkGroup->id,
    ];

    // When
    Bookmark::factory()->create(Arr::add($data, 'order', 3));
    Bookmark::factory()->create(Arr::add($data, 'order', 1));
    Bookmark::factory()->create(Arr::add($data, 'order', 2));
    Bookmark::factory()->create(Arr::add($data, 'order', 4));

    // Then
    $order = 1;

    Bookmark::each(function (Bookmark $bookmark) use (&$order) {
        assertEquals($order, $bookmark->order);

        $order++;
    });
});

it('auto increments order', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create();

    $data = [
        'name' => fake()->name(),
        'url' => fake()->url(),
        'icon' => '',
        'order' => null,
        'bookmark_group_id' => $bookmarkGroup->id,
    ];

    // When
    $bookmarks = collect([]);

    for ($i = 1; $i < rand(2, 10); $i++) {
        $bookmarks->add(Bookmark::factory()->create($data));
    }
    // Then
    $i = 1;

    $bookmarks->each(function (Bookmark $bookmark) use (&$i) {
        assertEquals($i, $bookmark->order);

        $i++;
    });
});
