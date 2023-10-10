<?php

namespace Tests\Unit\Models;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has bookmarks relation and returns collection', function () {
    // Given
    $bookmark = BookmarkGroup::factory()->withBookmarks(5)->create();

    // Then
    assertTrue($bookmark->isRelation('bookmarks'));
    assertCount(5, $bookmark->bookmarks);
    assertInstanceOf(Collection::class, $bookmark->bookmarks);
    assertInstanceOf(Bookmark::class, $bookmark->bookmarks->first());
});

it('returns bookmark groups sorted by column "order"', function () {
    // Given
    BookmarkGroup::factory()->create(['order' => 3]);
    BookmarkGroup::factory()->create(['order' => 1]);
    BookmarkGroup::factory()->create(['order' => 2]);
    BookmarkGroup::factory()->create(['order' => 4]);

    // Then
    $order = 1;

    BookmarkGroup::each(function (BookmarkGroup $bookmarkGroup) use (&$order) {
        assertEquals($order, $bookmarkGroup->order);

        $order++;
    });
});

it('auto increments order', function () {
    // Given
    BookmarkGroup::factory(rand(2, 10), ['order' => null])->create();

    // Then
    $order = 1;

    BookmarkGroup::each(function (BookmarkGroup $bookmarkGroup) use (&$order) {
        assertEquals($order, $bookmarkGroup->order);

        $order++;
    });
});
