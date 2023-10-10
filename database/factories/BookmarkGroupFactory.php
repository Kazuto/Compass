<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Bookmark;
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
                $bookmarkGroup->order = BookmarkGroup::max('order') + 1;
            })
            ->afterCreating(function (BookmarkGroup $bookmarkGroup) {
            });
    }

    public function withBookmarks(int $count = 1): static
    {
        return $this->afterCreating(function (BookmarkGroup $bookmarkGroup) use ($count) {
            Bookmark::factory($count)->for($bookmarkGroup)->create();
        });
    }
}
