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
        Schema::table('users', function (Blueprint $table) {
            // Add new fields for agent management
            $table->string('id_number')->unique()->nullable()->after('id');
            $table->string('first_name')->nullable()->after('id_number');
            $table->string('second_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('second_name');

            // Make email nullable since agents will use ID + PIN to login
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update any NULL emails to a default value before making it NOT NULL
        DB::table('users')
            ->whereNull('email')
            ->update(['email' => DB::raw("CONCAT('user_', id, '@temp.local')")]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_number', 'first_name', 'second_name', 'last_name']);

            // Restore email as required
            $table->string('email')->nullable(false)->change();
        });
    }
};
