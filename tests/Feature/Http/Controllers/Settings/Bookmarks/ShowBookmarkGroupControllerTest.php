<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()
        ->has(Bookmark::factory(5))
        ->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()
        ->has(Bookmark::factory(5))
        ->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('shows bookmark group', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()
        ->has(Bookmark::factory(5))
        ->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->get(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_OK)
        ->assertSee($bookmarkGroup->name)
        ->assertSeeInOrder($bookmarkGroup->bookmarks->pluck('name')->toArray());
});
