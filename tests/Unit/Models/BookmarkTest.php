<?php

namespace Tests\Unit\Models;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has bookmark group relation and returns model', function () {
    $bookmark = Bookmark::factory()->create();

    assertTrue($bookmark->isRelation('bookmarkGroup'));
    assertInstanceOf(BookmarkGroup::class, $bookmark->bookmarkGroup);
});

it('returns bookmarks sorted by column "order"', function () {
    $bookmarkGroup = BookmarkGroup::factory()->create();

    for ($i = 1; $i < rand(2, 10); $i++) {
        $data = [
            'name' => fake()->name(),
            'url' => fake()->url(),
            'icon' => '',
            'bookmark_group_id' => $bookmarkGroup->id,
        ];

        Bookmark::create($data);
    }

    $order = 1;

    Bookmark::each(function (Bookmark $bookmark) use (&$order) {
        assertEquals($order, $bookmark->order);

        $order++;
    });
});

it('auto increments order', function () {
    $bookmarkGroup = BookmarkGroup::factory()->create();

    for ($i = 1; $i < rand(2, 10); $i++) {
        $data = [
            'name' => fake()->name(),
            'url' => fake()->url(),
            'icon' => '',
            'bookmark_group_id' => $bookmarkGroup->id,
        ];

        tap(Bookmark::create($data), function (Bookmark $bookmark) use ($i) {
            assertEquals($i, $bookmark->order);
        });
    }
});
