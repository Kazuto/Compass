<?php

namespace Tests\Http\Controllers\Auth;

use App\Models\WhitelistAccess;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseHas;

function mockSocialiteUser(string $name = null, string $email = null): void
{
    $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');

    $abstractUser
        ->shouldReceive('getId')
        ->andReturn(rand())
        ->shouldReceive('getName')
        ->andReturn($name ?? Str::random(10))
        ->shouldReceive('getEmail')
        ->andReturn($email ?? Str::random(10).'@gmail.com')
        ->shouldReceive('getAvatar')
        ->andReturn('https://en.gravatar.com/userimage');

    Socialite::shouldReceive('driver->user')->andReturn($abstractUser);
}

it('redirects to login when email not whitelisted', function () {
    // Given
    mockSocialiteUser();

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.login'))
        ->assertSessionHas('error', "The E-Mail assigned to your account is not whitelisted. \n\n Please talk to an administrator for access.");
});

it('creates whitelist entry if logged in as admin', function () {
    // Given
    Config::set('compass.auth.whitelist_admin_email', $email = 'loren@ipsum.dolor');
    mockSocialiteUser(email: $email);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseHas('whitelist_access', ['email' => $email]);
});

it('authenticates if whitelist access entry exists', function () {
    // Given
    WhitelistAccess::factory()->create(['email' => $email = 'loren@ipsum.dolor']);
    mockSocialiteUser(email: $email);

    // When
    /** @var TestResponse $response */
    $response = $this
        ->get(route('auth.callback', ['provider' => 'github']));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('dashboard'));

    assertDatabaseHas('whitelist_access', ['email' => $email, 'is_active' => true]);
});
