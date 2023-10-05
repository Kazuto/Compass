<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whitelist_access', function (Blueprint $table) {
            $table->id();
            $table->text('email');
            $table->boolean('is_available')->default(1);
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whitelist_access');
    }
};
