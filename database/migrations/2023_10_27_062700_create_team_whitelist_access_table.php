<?php

declare(strict_types=1);

use App\Models\Team;
use App\Models\WhitelistAccess;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_whitelist_access', function (Blueprint $table) {
            $table->foreignIdFor(Team::class);
            $table->foreignIdFor(WhitelistAccess::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_whitelist_access');
    }
};
