<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Models\BookmarkGroup;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

it('redirects to login when unauthenticated', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.bookmarks.groups.store'), $bookmarkGroup->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));

    assertDatabaseEmpty('bookmark_groups');
});

it('creates the bookmark and redirects', function () {
    // Given
    $bookmarkGroup = BookmarkGroup::factory()->make()->withoutRelations()->toArray();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.bookmarks.groups.store'), $bookmarkGroup);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.bookmarks.list'))
        ->assertSessionHas('success', 'The bookmark group was added successfully.');

    assertDatabaseHas('bookmark_groups', $bookmarkGroup);
});
