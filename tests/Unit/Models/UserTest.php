<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertTrue;

it('has whitelist access relation and returns model', function () {
    // When
    $whitelist = User::factory()
        ->hasWhitelistAccess()
        ->create();

    // Then
    assertTrue($whitelist->isRelation('whitelistAccess'));
    assertInstanceOf(WhitelistAccess::class, $whitelist->whitelistAccess);
});

it('has teams relation and returns collection', function () {
    // When
    $whitelist = User::factory()
        ->belongsToTeam()
        ->create();

    // Then
    assertTrue($whitelist->isRelation('teams'));
    assertCount(1, $whitelist->teams);
    assertInstanceOf(Collection::class, $whitelist->teams);
    assertInstanceOf(Team::class, $whitelist->teams()->first());
});

it('returns icon for oauth provider', function ($provider, $hint) {
    // Given
    $user = User::factory()
        ->hasWhitelistAccess()
        ->create([
            'oauth_provider' => $provider,
        ]);

    // Then
    assertStringContainsString($hint, $user->getAuthProviderIcon()->toHtml());
})->with([
    ['github', 'GitHub OAuth'],
    ['microsoft', 'Microsoft OAuth'],
    [null, 'Basic Auth (Password)'],
]);
