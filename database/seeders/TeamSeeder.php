<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BookmarkGroup;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::factory(3)
            ->create()
            ->each(function (Team $team) {
                $team->users()->sync(User::factory(rand(0, 7))->create());

                $bookmarkGroups = BookmarkGroup::all()->isEmpty()
                    ? BookmarkGroup::factory(rand(0, 3))->create()
                    : BookmarkGroup::inRandomOrder()->take(rand(0, 3))->get();

                if ($bookmarkGroups->isNotEmpty()) {
                    $team->bookmarkGroups()->sync($bookmarkGroups);
                }
            });
    }
}
