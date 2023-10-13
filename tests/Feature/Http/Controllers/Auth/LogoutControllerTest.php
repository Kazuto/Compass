<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertTrue;

it('logs out and redirects to login', function () {
    // When
    /** @var TestResponse $response */
    $response = $this
        ->actingAs(User::factory()->create())
        ->get(route('auth.logout'));

    // Then
    $response
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect(route('auth.index'));

    assertTrue(Auth::guest());
});
