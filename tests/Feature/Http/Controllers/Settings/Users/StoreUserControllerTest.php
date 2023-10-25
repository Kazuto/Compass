<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Settings\Users;

use App\Actions\User\StoreUserAction;
use App\Actions\User\UpdateUserAction;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\travel;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

it('redirects to login when unauthenticated', function () {
    // Given
    $user = User::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->post(route('settings.users.store'), $user->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));
});

it('redirects to dashboard if not admin', function () {
    // Given
    $user = User::factory()->make();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->post(route('settings.users.store'), $user->withoutRelations()->toArray());

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));
});

it('creates the user and redirects', function () {
    // Given
    $payload = [
        'name' => 'J.D.',
        'username' => 'j_d',
        'password' => $password = fake()->password(8),
        'confirm_password' => $password,
        'email' => 'jdoe@app.test',
        'is_admin' => true,
    ];

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.users.store'), $payload);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.users.list'))
        ->assertSessionHas('success', 'The user was created successfully.');

    assertDatabaseCount('users', 2);


    tap(User::latest('id')->first(), function (User $user) {
        assertEquals('J.D.', $user->name);
        assertEquals('j_d', $user->username);
        assertEquals('jdoe@app.test', $user->email);
        assertTrue($user->is_admin);
    });
});

it('catches exception and redirects with message', function () {
    // Given
    $payload = [
        'name' => 'J.D.',
        'username' => 'j_d',
        'password' => $password = fake()->password(8),
        'confirm_password' => $password,
        'email' => 'jdoe@app.test',
        'is_admin' => true,
    ];

    $this->mockActionThrows(StoreUserAction::class);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->isAdmin()->create())
        ->post(route('settings.users.store'), $payload);

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('settings.users.list'))
        ->assertSessionHas('error', 'Something went wrong!');
});
