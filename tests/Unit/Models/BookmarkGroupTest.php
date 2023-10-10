<?php

namespace Tests\Unit\Models;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has bookmarks relation and returns collection', function () {
    // When
    $bookmark = BookmarkGroup::factory()->withBookmarks(5)->create();

    // Then
    assertTrue($bookmark->isRelation('bookmarks'));
    assertCount(5, $bookmark->bookmarks);
    assertInstanceOf(Collection::class, $bookmark->bookmarks);
    assertInstanceOf(Bookmark::class, $bookmark->bookmarks->first());
});

it('returns bookmark groups sorted by column "order"', function () {
    //
    $data = ['name' => fake()->name()];

    // When
    BookmarkGroup::factory()->create(Arr::add($data, 'order', 3));
    BookmarkGroup::factory()->create(Arr::add($data, 'order', 1));
    BookmarkGroup::factory()->create(Arr::add($data, 'order', 2));
    BookmarkGroup::factory()->create(Arr::add($data, 'order', 3));

    // Then
    $order = 1;

    BookmarkGroup::each(function (BookmarkGroup $bookmarkGroup) use (&$order) {
        assertEquals($order, $bookmarkGroup->order);

        $order++;
    });
});

it('auto increments order', function () {
    // Given
    $data = ['name' => fake()->name()];

    // When
    $bookmarkGroups = collect([]);

    for ($i = 1; $i < rand(2, 10); $i++) {
        $bookmarkGroups->add(BookmarkGroup::create($data));
    }

    // Then
    $i = 1;

    $bookmarkGroups->each(function (BookmarkGroup $bookmarkGroup) use (&$i) {
        assertEquals($i, $bookmarkGroup->order);

        $i++;
    });
});
