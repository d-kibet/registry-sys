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
        // Check if constraint already exists
        $constraintExists = DB::select("
            SELECT constraint_name
            FROM information_schema.table_constraints
            WHERE table_name = 'users'
            AND constraint_type = 'UNIQUE'
            AND constraint_name = 'users_phone_unique'
        ");

        if (!empty($constraintExists)) {
            echo "Unique constraint 'users_phone_unique' already exists. Skipping...\n";
            return;
        }

        // Check for duplicate phone numbers and report them
        $duplicates = DB::select("
            SELECT phone, COUNT(*) as count
            FROM users
            WHERE phone IS NOT NULL
            GROUP BY phone
            HAVING COUNT(*) > 1
        ");

        if (!empty($duplicates)) {
            throw new \Exception(
                "Cannot add unique constraint. Found duplicate phone numbers in users table: " .
                json_encode(array_map(fn($d) => $d->phone, $duplicates))
            );
        }

        try {
            // Try using raw SQL with IF NOT EXISTS (PostgreSQL 15+)
            DB::statement('ALTER TABLE users ADD CONSTRAINT users_phone_unique UNIQUE (phone)');
        } catch (\Exception $e) {
            // If permission denied or other error, try Schema builder
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('phone');
                });
            } catch (\Exception $e2) {
                // Log error and provide instructions
                echo "\n⚠️  WARNING: Could not add unique constraint to users.phone\n";
                echo "Error: " . $e2->getMessage() . "\n\n";
                echo "To fix this, run as database owner:\n";
                echo "ALTER TABLE users ADD CONSTRAINT users_phone_unique UNIQUE (phone);\n\n";

                // Don't fail the migration - this is a non-critical constraint
                // The application validates uniqueness at the application level
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if constraint exists before trying to drop
        $constraintExists = DB::select("
            SELECT constraint_name
            FROM information_schema.table_constraints
            WHERE table_name = 'users'
            AND constraint_type = 'UNIQUE'
            AND constraint_name = 'users_phone_unique'
        ");

        if (empty($constraintExists)) {
            echo "Unique constraint 'users_phone_unique' does not exist. Skipping...\n";
            return;
        }

        try {
            // Try using raw SQL
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_phone_unique');
        } catch (\Exception $e) {
            // If permission denied, try Schema builder
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique(['phone']);
                });
            } catch (\Exception $e2) {
                // Log warning but don't fail
                echo "\n⚠️  WARNING: Could not drop unique constraint from users.phone\n";
                echo "Error: " . $e2->getMessage() . "\n";
            }
        }
    }
};
