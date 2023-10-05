<?php

declare(strict_types=1);

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\WhitelistAccess>
 */
class WhitelistAccessFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'is_available' => fake()->boolean(85),
        ];
    }
}
