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
            'icon' => fake()->randomElement([
                'fab-github',
                'fab-microsoft',
                'phosphor-microsoft-outlook-logo-fill',
                'fab-confluence',
                'fab-atlassian',
                '',
            ]),
        ];
    }

    public function configure(): static
    {
        return $this
            ->afterMaking(function (Bookmark $bookmark) {
                $bookmarkGroup = BookmarkGroup::inRandomOrder()->first() ?? BookmarkGroup::factory()->create();

                $bookmark->bookmarkGroup()->associate($bookmarkGroup);
                $bookmark->order = Bookmark::where('bookmark_group_id', '=', $bookmarkGroup->id)->max('order') + 1;
            })
            ->afterCreating(function (Bookmark $bookmark) {
            });
    }

    public function withIcon(): static
    {
        return $this->afterMaking(function (Bookmark $bookmark) {
            $bookmark->icon = '󰇉';
        });
    }

    public function belongsToBookmarkGroup(BookmarkGroup $bookmarkGroup): static
    {
        return $this
            ->afterMaking(function (Bookmark $bookmark) use ($bookmarkGroup) {
                $bookmark->bookmarkGroup()->associate($bookmarkGroup);
            });
    }
}
