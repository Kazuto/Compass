<?php

namespace Tests\Unit\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has whitelist access relation and returns model', function () {
    $whitelist = User::factory()
        ->hasWhitelistAccess()
        ->create();

    assertTrue($whitelist->isRelation('whitelistAccess'));
    assertInstanceOf(WhitelistAccess::class, $whitelist->whitelistAccess);
});

it('has teams relation and returns collection', function () {
    $whitelist = User::factory()
        ->belongsToTeam()
        ->create();

    assertTrue($whitelist->isRelation('teams'));
    assertCount(1, $whitelist->teams);
    assertInstanceOf(Collection::class, $whitelist->teams);
    assertInstanceOf(Team::class, $whitelist->teams()->first());
});
