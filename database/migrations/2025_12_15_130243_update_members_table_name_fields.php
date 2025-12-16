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
            // Add split name fields after full_name
            $table->string('first_name')->nullable()->after('constituency_id');
            $table->string('second_name')->nullable()->after('first_name');
            $table->string('third_name')->nullable()->after('second_name');

            // Keep full_name for backward compatibility and for easier searching
            // It will be auto-populated from first + second + third names
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'second_name', 'third_name']);
        });
    }
};
