<?php

declare(strict_types=1);

use App\Models\BookmarkGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->text('name');
            $table->text('url');
            $table->text('icon')->nullable();
            $table->integer('order')->default('0');
            $table->foreignIdFor(BookmarkGroup::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
