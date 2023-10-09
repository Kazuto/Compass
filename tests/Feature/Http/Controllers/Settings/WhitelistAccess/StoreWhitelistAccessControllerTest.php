<?php

namespace Tests\Http\Controllers\Settings\Teams;

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
        ->assertRedirect(route('auth.login'));

    assertDatabaseEmpty('whitelist_access');
});

it('creates the team and redirects', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->make()->withoutRelations()->toArray();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.whitelist.store'), $whitelistAccess);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('success', 'The whitelist entry was added successfully.');

    assertDatabaseHas('whitelist_access', $whitelistAccess);
});
