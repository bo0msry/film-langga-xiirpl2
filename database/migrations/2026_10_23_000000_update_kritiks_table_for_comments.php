<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Align the existing kritiks table with the comment feature.
     */
    public function up(): void
    {
        if (Schema::hasColumn('kritiks', 'comment') && ! Schema::hasColumn('kritiks', 'isi')) {
            Schema::table('kritiks', function (Blueprint $table) {
                $table->renameColumn('comment', 'isi');
            });
        }

        if (Schema::hasColumn('kritiks', 'rating')) {
            Schema::table('kritiks', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }
    }

    /**
     * Reverse the schema changes.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kritiks', 'isi') && ! Schema::hasColumn('kritiks', 'comment')) {
            Schema::table('kritiks', function (Blueprint $table) {
                $table->renameColumn('isi', 'comment');
            });
        }

        if (! Schema::hasColumn('kritiks', 'rating')) {
            Schema::table('kritiks', function (Blueprint $table) {
                $table->integer('rating')->default(0);
            });
        }
    }
};
