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
        Schema::table('members', function (Blueprint $table) {
            // Drop the old JSON column
            $table->dropColumn('vie_positions');
            // Add new string column for single position
            $table->string('vie_position')->nullable()->after('wants_to_vie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Restore the JSON column
            $table->dropColumn('vie_position');
            $table->json('vie_positions')->nullable()->after('wants_to_vie');
        });
    }
};
