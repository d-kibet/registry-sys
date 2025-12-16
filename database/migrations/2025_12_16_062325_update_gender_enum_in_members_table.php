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
        // Clean up any leftover columns from failed migrations
        if (Schema::hasColumn('members', 'gender_temp')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('gender_temp');
            });
        }

        // Update any 'Prefer not to say' values to 'Male' (default)
        DB::table('members')
            ->where('gender', 'Prefer not to say')
            ->update(['gender' => 'Male']);

        // Update any NULL gender values to 'Male'
        DB::table('members')
            ->whereNull('gender')
            ->update(['gender' => 'Male']);

        // For PostgreSQL, we need to recreate the column with new enum values
        Schema::table('members', function (Blueprint $table) {
            $table->string('gender_temp')->nullable()->after('gender');
        });

        // Copy data to temp column, setting default 'Male' for any NULL values
        DB::statement("UPDATE members SET gender_temp = COALESCE(gender, 'Male')");

        // Drop old column and recreate with new enum (nullable first)
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female'])->nullable()->after('id_number');
        });

        // Copy data back from temp column
        DB::statement("UPDATE members SET gender = gender_temp");

        // Make gender NOT NULL after data is populated
        DB::statement("ALTER TABLE members ALTER COLUMN gender SET NOT NULL");

        // Drop temp column
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('gender_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate with old enum values
        Schema::table('members', function (Blueprint $table) {
            $table->string('gender_temp')->nullable()->after('gender');
        });

        DB::statement("UPDATE members SET gender_temp = gender");

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female', 'Prefer not to say'])->after('id_number');
        });

        DB::statement("UPDATE members SET gender = gender_temp");

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('gender_temp');
        });
    }
};
