<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\WhitelistAccess;
use Illuminate\Database\Seeder;

class WhitelistAccessSeeder extends Seeder
{
    public function run(): void
    {
        WhitelistAccess::factory(5)->create();
    }
}
