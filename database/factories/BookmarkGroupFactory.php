<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BookmarkGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookmarkGroup>
 */
class BookmarkGroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(rand(1, 3), true),
        ];
    }

    public function configure(): static
    {
        return $this
            ->afterMaking(function (BookmarkGroup $bookmarkGroup) {
            })
            ->afterCreating(function (BookmarkGroup $bookmarkGroup) {
                $bookmarkGroup->update([
                    'order' => BookmarkGroup::max('order') + 1,
                ]);
            });
    }
}
