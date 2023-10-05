<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Bookmark;
use App\Models\BookmarkGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookmarkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(rand(1, 3), true),
            'url' => fake()->url(),
            'icon' => fake()->randomElement(['󰋜', '󰎖', '󱂚', '󰀻', '󰠄', '󰸏', '󰨥', '󰭹', '󰄜', '', '󰙀', '󰒓', '󰥧', '󰊤', '󰊢', '󰌄', '󰌽', '󰫐']),
        ];
    }

    public function configure(): static
    {
        return $this
            ->afterMaking(function (Bookmark $bookmark) {
                $bookmark->group()->associate(BookmarkGroup::inRandomOrder()->first());
            })
            ->afterCreating(function (Bookmark $bookmark) {
                $bookmark->update([
                    'order' => Bookmark::where('bookmark_group_id', '=', $bookmark->bookmark_group_id)->max('order') + 1,
                ]);
            });
    }
}
