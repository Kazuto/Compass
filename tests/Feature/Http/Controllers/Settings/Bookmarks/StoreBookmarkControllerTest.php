<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Actions\Bookmarks\StoreBookmarkAction;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmark = Bookmark::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.bookmarks.store'), $bookmark->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));

    assertDatabaseEmpty('bookmarks');
});

it('redirects to dashboard if not admin', function () {
    // Given
    $bookmark = Bookmark::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.bookmarks.store'), $bookmark->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseEmpty('bookmarks');
});

it('creates the bookmark and redirects', function () {
    // Given
    $bookmark = Bookmark::factory()->withIcon()->make()->withoutRelations()->toArray();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.bookmarks.store'), $bookmark);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.list'))
        ->assertSessionHas('success', 'The bookmark was added successfully.');

    assertDatabaseHas('bookmarks', $bookmark);
});

it('catches exception and redirects with message', function () {
    // Given
    $bookmark = Bookmark::factory()->withIcon()->make()->withoutRelations()->toArray();

    $this->mockActionThrows(StoreBookmarkAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.bookmarks.store'), $bookmark);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
