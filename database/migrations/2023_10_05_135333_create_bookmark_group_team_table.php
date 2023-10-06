<?php

use App\Models\BookmarkGroup;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmark_group_team', function (Blueprint $table) {
            $table->foreignIdFor(BookmarkGroup::class);
            $table->foreignIdFor(Team::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmark_group_team');
    }
};
