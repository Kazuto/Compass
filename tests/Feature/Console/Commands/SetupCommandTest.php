<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\SetupCommand;
use Illuminate\Support\Facades\Artisan;

use function Pest\Laravel\assertDatabaseHas;

it('creates new user', function () {
    // Given
    config()->set('compass.admin.username', $username = fake()->userName());
    config()->set('compass.admin.email', $email = fake()->safeEmail());

    // When
    Artisan::call(SetupCommand::class);

    // Then
    assertDatabaseHas('users', [
        'username' => $username,
        'email' => $email,
    ]);
});
