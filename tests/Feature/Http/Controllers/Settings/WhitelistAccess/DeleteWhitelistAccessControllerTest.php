<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\WhitelistAccess;

use App\Actions\WhitelistAccess\DeleteWhitelistAccessAction;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertSoftDeleted;

it('redirects to login when unauthenticated', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->delete(route('settings.whitelist.delete', ['whitelistAccess' => $whitelistAccess]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'));
});

it('deletes the whitelist access entry and redirects', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->delete(route('settings.whitelist.delete', ['whitelistAccess' => $whitelistAccess]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('success', 'The whitelist entry was deleted successfully.');

    assertSoftDeleted('whitelist_access', ['id' => $whitelistAccess->id]);
});

it('catches exception and redirects with message', function () {
    // Given
    $whitelistAccess = WhitelistAccess::factory()->create();

    $this->mockActionThrows(DeleteWhitelistAccessAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->delete(route('settings.whitelist.delete', ['whitelistAccess' => $whitelistAccess]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.whitelist.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
