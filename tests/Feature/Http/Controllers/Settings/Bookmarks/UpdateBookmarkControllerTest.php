<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\UpdateBookmarkAction;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertEquals;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmark = Bookmark::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->patch(route('settings.bookmarks.update', ['bookmark' => $bookmark]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));
});

it('updates the bookmark and redirects', function () {
    // Given
    $bookmark = Bookmark::factory()->withIcon()->create([
        'name' => 'test bookmark',
        'url' => 'http://compass.test',
        'icon' => '󰤑',
    ]);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->patch(route('settings.bookmarks.update', ['bookmark' => $bookmark]), [
            'name' => $bookmark->name,
            'url' => $bookmark->url,
            'icon' => '󰙨',
            'bookmark_group_id' => $bookmark->bookmarkGroup->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmark->bookmarkGroup]))
        ->assertSessionHas('success', 'The bookmark was updated successfully.');

    tap($bookmark->refresh(), function (Bookmark $bookmark) {
        assertEquals('test bookmark', $bookmark->name);
        assertEquals('http://compass.test', $bookmark->url);
        assertEquals('󰙨', $bookmark->icon);
    });
});

it('catches exception and redirects with message', function () {
    // Given
    $bookmark = Bookmark::factory()->withIcon()->create([
        'name' => 'test bookmark',
        'url' => 'http://compass.test',
        'icon' => '󰤑',
    ]);

    $this->mockActionThrows(UpdateBookmarkAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->patch(route('settings.bookmarks.update', ['bookmark' => $bookmark]), [
            'name' => $bookmark->name,
            'url' => $bookmark->url,
            'icon' => '󰙨',
            'bookmark_group_id' => $bookmark->bookmarkGroup->id,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmark->bookmarkGroup]))
        ->assertSessionHas('error', 'Something went wrong!');
});
