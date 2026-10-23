<?php

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
        Schema::create('cast_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cast_id')->constrained()->cascadeOnDelete();
            $table->string('role', 100);
            $table->timestamps();

            // Satu pemeran hanya boleh berperan satu kali di dalam satu film.
            $table->unique(['film_id', 'cast_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cast_movie');
    }
};
