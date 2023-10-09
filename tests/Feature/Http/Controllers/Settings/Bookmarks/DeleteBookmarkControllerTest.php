<?php

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\assertSoftDeleted;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmark = Bookmark::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->delete(route('settings.bookmarks.delete', ['bookmark' => $bookmark]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));

    assertNotSoftDeleted('bookmarks', ['id' => $bookmark->id]);
});

it('soft deletes the bookmark and redirects', function () {
    // Given
    $bookmark = Bookmark::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->delete(route('settings.bookmarks.delete', ['bookmark' => $bookmark]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmark->bookmarkGroup]))
        ->assertSessionHas('success', 'The bookmark was deleted successfully.');

    assertSoftDeleted('bookmarks', ['id' => $bookmark->id]);
});
