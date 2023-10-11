<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Models\BookmarkGroup;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\assertSoftDeleted;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->delete(route('settings.bookmarks.groups.delete', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));

    assertNotSoftDeleted('bookmark_groups', ['id' => $bookmarkGroup->id]);
});

it('soft deletes the bookmark group and redirects', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->delete(route('settings.bookmarks.groups.delete', ['bookmarkGroup' => $bookmarkGroup]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.list'))
        ->assertSessionHas('success', 'The bookmark group was deleted successfully.');

    assertSoftDeleted('bookmark_groups', ['id' => $bookmarkGroup->id]);
});
