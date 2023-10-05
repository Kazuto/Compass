<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BookmarkGroup;
use Illuminate\Database\Seeder;

class BookmarkGroupSeeder extends Seeder
{
    public function run(): void
    {
        BookmarkGroup::factory(8)->create();
    }
}
