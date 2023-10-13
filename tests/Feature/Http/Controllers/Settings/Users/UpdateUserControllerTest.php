<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Bookmarks;

use App\Actions\User\UpdateUserAction;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

it('redirects to login when unauthenticated', function () {
    // Given
    $user = User::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->patch(route('settings.users.update', ['user' => $user]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    $user = User::factory()->create();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->patch(route('settings.users.update', ['user' => $user]));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('updates the user and redirects', function () {
    // Given
    $user = User::factory()->create([
        'name' => 'John Doe',
        'username' => 'j_doe',
        'is_admin' => false,
    ]);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->patch(route('settings.users.update', ['user' => $user]), [
            'name' => 'J.D.',
            'username' => 'j_d',
            'email' => $user->email,
            'is_admin' => true,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.users.list'))
        ->assertSessionHas('success', 'The user was updated successfully.');

    tap($user->refresh(), function (User $user) {
        assertEquals('J.D.', $user->name);
        assertEquals('j_d', $user->username);
        assertTrue($user->is_admin);
    });
});

it('catches exception and redirects with message', function () {
    // Given
    $user = User::factory()->create([
        'name' => 'John Doe',
        'username' => 'j_doe',
        'is_admin' => false,
    ]);

    $this->mockActionThrows(UpdateUserAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->patch(route('settings.users.update', ['user' => $user]), [
            'name' => 'J.D.',
            'username' => 'j_d',
            'email' => $user->email,
            'is_admin' => true,
        ]);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.users.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
