<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has user relation and returns model', function () {
    // When
    $whitelist = WhitelistAccess::factory()
        ->for(User::factory())
        ->create();

    // Then
    assertTrue($whitelist->isRelation('user'));
    assertInstanceOf(User::class, $whitelist->user);
});

it('returns correct entry when scope forEmail is used', function () {
    // When
    $whitelist = WhitelistAccess::factory()
        ->for(User::factory())
        ->create(['email' => $email = fake()->safeEmail()]);

    // Then
    tap(WhitelistAccess::forEmail($email)->get(), function (Collection $records) use ($whitelist) {
        assertCount(1, $records);
        assertEquals($whitelist->refresh()->toArray(), $records->first()->toArray());
    });
});

it('returns correct entry when scope active is used', function ($activeCount, $inactiveCount) {
    // When
    WhitelistAccess::factory($activeCount)->create(['is_active' => true]);
    WhitelistAccess::factory($inactiveCount)->create(['is_active' => false]);

    // Then
    tap(WhitelistAccess::active()->get(), function (Collection $records) use ($activeCount) {
        assertCount($activeCount, $records);
    });
})->with([
    '12 active & 14 inactive' => [12, 14],
    '7 active & 22 inactive' => [7, 22],
    '19 active & 2 inactive' => [19, 2],
]);

it('returns correct entry when scope inactive is used', function ($activeCount, $inactiveCount) {
    // When
    WhitelistAccess::factory($activeCount)->create(['is_active' => true]);
    WhitelistAccess::factory($inactiveCount)->create(['is_active' => false]);

    // Then
    tap(WhitelistAccess::inactive()->get(), function (Collection $records) use ($inactiveCount) {
        assertCount($inactiveCount, $records);
    });
})->with([
    '12 active & 14 inactive' => [12, 14],
    '7 active & 22 inactive' => [7, 22],
    '19 active & 2 inactive' => [19, 2],
]);

it('returns true for whitelisted email when calling isWhitelisted', function () {
    // When
    WhitelistAccess::factory()->create(['email' => $email = fake()->safeEmail()]);

    // Then
    assertTrue(WhitelistAccess::isWhitelisted($email));
});

it('returns false for non-whitelisted email when calling isWhitelisted', function () {
    assertFalse(WhitelistAccess::isWhitelisted(fake()->safeEmail()));
});

it('returns true for whitelisted email when calling isNonWhitelisted', function () {
    assertTrue(WhitelistAccess::isNotWhitelisted(fake()->safeEmail()));
});

it('returns false for whitelisted email when calling isNonWhitelisted', function () {
    // When
    WhitelistAccess::factory()->create(['email' => $email = fake()->safeEmail()]);

    // Then
    assertFalse(WhitelistAccess::isNotWhitelisted($email));
});
