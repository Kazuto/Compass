<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertStringContainsString;
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

it('returns question mark icon for invalid icon', function () {
    // Given
    $bookmark = Bookmark::factory()->create();

    // When
    $bookmark->update(['icon' => 'test']);

    // Then
    assertEquals('question-circle', $bookmark->svgIcon()->name());

    assertStringContainsString(
        'M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z',
        $bookmark->svgIcon()->contents()
    );
});
