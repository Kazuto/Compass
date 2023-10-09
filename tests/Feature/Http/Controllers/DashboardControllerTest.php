<?php

namespace Tests\Http\Controllers;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // Given
    BookmarkGroup::factory(3)->create();
    Bookmark::factory(20)->create();

    // When
    /** @var TestResponse $response */
    $response = $this->get(route('dashboard'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));
});

it('shows all bookmark groups', function () {
    // Given
    $bookmarkGroups = BookmarkGroup::factory(3)->create();
    Bookmark::factory(20)->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('dashboard'));

    // Then
    $response->assertStatus(Response::HTTP_OK);

    $bookmarkGroups->each(function (BookmarkGroup $bookmarkGroup) use ($response) {
        $response->assertSee($bookmarkGroup->name);
        $response->assertSeeInOrder($bookmarkGroup->bookmarks->pluck('name')->toArray());
    });
});

it('shows only accessible bookmark groups', function ($count) {
    // Given
    $bookmarkGroups = BookmarkGroup::factory(10)->withBookmarks(rand(3, 10))->create();

    $user = User::factory()->belongsToTeam()->create();

    /** @var BookmarkGroup $randomBookmarkGroup */
    $randomBookmarkGroups = $bookmarkGroups->random($count)->first();
    $user->teams->first()->bookmarkGroups()->sync($randomBookmarkGroups);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    // Then
    $randomBookmarkGroups->each(function (BookmarkGroup $bookmarkGroup) use ($response) {
        $response->assertSee($bookmarkGroup->name);
        $response->assertSeeInOrder($bookmarkGroup->bookmarks->pluck('name')->toArray());
    });
})->with([
    'one group' => 1,
    'two groups' => 2,
    'three groups' => 3,
    'five groups' => 5,
]);
