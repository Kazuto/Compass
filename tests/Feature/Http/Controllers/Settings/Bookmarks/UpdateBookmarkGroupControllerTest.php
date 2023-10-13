<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\UpdateBookmarkGroupAction;
use App\Models\BookmarkGroup;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertEquals;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->patch(route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->patch(route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('updates the bookmark and redirects', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create([
        'name' => 'test bookmark group',
    ]);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->patch(route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]), [
            'name' => 'updated bookmark group',
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]))
        ->assertSessionHas('success', 'The bookmark group was updated successfully.');

    tap($bookmarkGroup->refresh(), function (BookmarkGroup $bookmarkGroup) {
        assertEquals('updated bookmark group', $bookmarkGroup->name);
    });
});

it('catches exception and redirects with message', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create([
        'name' => 'test bookmark group',
    ]);

    $this->mockActionThrows(UpdateBookmarkGroupAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->patch(route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]), [
            'name' => 'updated bookmark group',
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]))
        ->assertSessionHas('error', 'Something went wrong!');
});
