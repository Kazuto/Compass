<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('oauth_provider')->nullable();
            $table->string('oauth_id')->nullable();
            $table->string('oauth_token')->nullable();
            $table->string('oauth_refresh_token')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();

            $table->unique(['oauth_provider', 'oauth_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
