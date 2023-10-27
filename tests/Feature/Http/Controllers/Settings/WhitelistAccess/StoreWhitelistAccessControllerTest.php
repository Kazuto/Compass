<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Teams;

use App\Actions\WhitelistAccess\StoreWhitelistAccessAction;
use App\Models\Team;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

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
    $data = [
        'email' => $email = fake()->safeEmail(),
        'team_ids' => [],
    ];

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.whitelist.store'), $data);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('success', 'The whitelist entry was added successfully.');

    assertDatabaseHas('whitelist_access', ['email' => $email]);
});

it('assigns team to whitelist access entry and redirects', function () {
    // Given
    $data = [
        'email' => $email = fake()->safeEmail(),
        'team_ids' => [
            Team::factory()->create()->id => 1,
            Team::factory()->create()->id => 0,
            Team::factory()->create()->id => 1,
        ],
    ];

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.whitelist.store'), $data);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('success', 'The whitelist entry was added successfully.');

    assertDatabaseHas('whitelist_access', ['email' => $email]);
    assertDatabaseHas('team_whitelist_access', ['whitelist_access_id' => 1, 'team_id' => 1]);
    assertDatabaseMissing('team_whitelist_access', ['whitelist_access_id' => 1, 'team_id' => 2]);
    assertDatabaseHas('team_whitelist_access', ['whitelist_access_id' => 1, 'team_id' => 3]);
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
