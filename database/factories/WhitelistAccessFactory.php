<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhitelistAccess>
 */
class WhitelistAccessFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'is_active' => fake()->boolean(5),
        ];
    }
}
