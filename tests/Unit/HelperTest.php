<?php

declare(strict_types=1);

namespace Tests\Unit;

use function PHPUnit\Framework\assertCount;

it('keyFromToggle returns only truthy items', function ($toggles, $expected) {
    assertCount($expected, keyFromToggle($toggles));
})->with([
    [[false, true, false], 1],
    [[false, false, false, false, true], 1],
    [[true, true], 2],
    [[true, false, true, false], 2],
    [[true], 1],
    [[false], 0],
    [[], 0],
]);
