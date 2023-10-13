<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\Models\WhitelistAccess;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }

    public function configure(): static
    {
        return $this
            ->afterMaking(function (User $model) {
            })
            ->afterCreating(function (User $model) {
            });
    }

    public function belongsToTeam(Team $team = null): static
    {
        $team = $team ?? Team::factory()->create();

        return $this->afterCreating(function (User $model) use ($team) {
            $model->teams()->attach($team);
        });
    }

    public function hasWhitelistAccess(WhitelistAccess $whitelistAccess = null): static
    {
        $whitelistAccess = $whitelistAccess ?? WhitelistAccess::factory()->create(['is_active' => true]);

        return $this->afterCreating(function (User $model) use ($whitelistAccess) {
            $whitelistAccess->user()->associate($model);
            $whitelistAccess->saveQuietly();
        });
    }

    public function wasNotRecentlyCreated(): static
    {
        return $this->afterCreating(function (User $model) {
            $model->wasRecentlyCreated = false;
        });
    }
}
