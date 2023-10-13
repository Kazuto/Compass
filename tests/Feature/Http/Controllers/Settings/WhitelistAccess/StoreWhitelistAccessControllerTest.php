<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\WhitelistAccess\StoreWhitelistAccessAction;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

it('redirects to login when unauthenticated', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.whitelist.store'), $whitelistAccess->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));

    assertDatabaseEmpty('whitelist_access');
});

it('redirects to dashboard if not admin', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.whitelist.store'), $whitelistAccess->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseEmpty('whitelist_access');
});

it('creates the whitelist access entry and redirects', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->make(['is_active' => 0])->withoutRelations()->toArray();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.whitelist.store'), $whitelistAccess);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('success', 'The whitelist entry was added successfully.');

    assertDatabaseHas('whitelist_access', $whitelistAccess);
});

it('catches exception and redirects with message', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->make(['is_active' => 0])->withoutRelations()->toArray();

    $this->mockActionThrows(StoreWhitelistAccessAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.whitelist.store'), $whitelistAccess);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
