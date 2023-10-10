<?php

namespace Tests\Unit\Models;

use App\Models\BookmarkGroup;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

it('has users relation and returns collection', function () {
    // Given
    $team = Team::factory()->has(User::factory(5))->create();

    // Then
    assertTrue($team->isRelation('users'));
    assertCount(5, $team->users);
    assertInstanceOf(Collection::class, $team->users);
    assertInstanceOf(User::class, $team->users->first());
});

it('has bookmark groups relation and returns collection', function () {
    // Given
    $team = Team::factory()->has(BookmarkGroup::factory(5))->create();

    // Then
    assertTrue($team->isRelation('bookmarkGroups'));
    assertCount(5, $team->bookmarkGroups);
    assertInstanceOf(Collection::class, $team->bookmarkGroups);
    assertInstanceOf(BookmarkGroup::class, $team->bookmarkGroups->first());
});

it('return matching team entries when calling isMember', function () {
    // Given
    $user = User::factory()->create();
    $team1 = Team::factory()->create();
    $team1->users()->attach($user);
    $team2 = Team::factory()->create();
    $team3 = Team::factory()->create();
    $team3->users()->attach($user);

    // When
    $result = Team::isMember($user)->get();

    // Then
    assertCount(2, $result);
    assertEquals($team1->name, $result->first()->name);
    assertEquals($team3->name, $result->last()->name);
});
