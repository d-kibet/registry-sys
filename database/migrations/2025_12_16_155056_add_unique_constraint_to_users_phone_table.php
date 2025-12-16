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

        // Add unique constraint to phone column
        Schema::table('users', function (Blueprint $table) {
            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
        });
    }
};
