<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert vie_position from string to enum for database-level validation
        // Create temp column with enum type
        Schema::table('members', function (Blueprint $table) {
            $table->enum('vie_position_temp', [
                'Youth Representative',
                'Women Representative',
                'PWDs Representative',
                'MSMEs Representative',
                'Farmers Representative',
                'Religious Groups Representative',
                'Professionals Representative'
            ])->nullable()->after('vie_position');
        });

        // Copy data to temp column
        DB::statement("UPDATE members SET vie_position_temp = vie_position WHERE vie_position IS NOT NULL");

        // Drop old string column
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('vie_position');
        });

        // Rename temp column to vie_position
        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('vie_position_temp', 'vie_position');
        });

        // Add index for filtering/reporting by vie position
        Schema::table('members', function (Blueprint $table) {
            $table->index('vie_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop index
        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex(['vie_position']);
        });

        // Convert back from enum to string
        Schema::table('members', function (Blueprint $table) {
            $table->string('vie_position_temp')->nullable()->after('vie_position');
        });

        DB::statement("UPDATE members SET vie_position_temp = vie_position WHERE vie_position IS NOT NULL");

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('vie_position');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('vie_position_temp', 'vie_position');
        });
    }
};
