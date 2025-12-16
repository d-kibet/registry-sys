<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration fixes the cascading delete issue on members table.
     * Changes registered_by and company_id foreign keys from cascade to set null
     * to preserve member records when users or companies are deleted.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['registered_by']);
            $table->dropForeign(['company_id']);

            // Make columns nullable
            $table->foreignId('registered_by')->nullable()->change();
            $table->foreignId('company_id')->nullable()->change();

            // Re-add foreign keys with set null on delete
            $table->foreign('registered_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the set null foreign keys
            $table->dropForeign(['registered_by']);
            $table->dropForeign(['company_id']);

            // Make columns non-nullable again
            $table->foreignId('registered_by')->nullable(false)->change();
            $table->foreignId('company_id')->nullable(false)->change();

            // Restore original cascade foreign keys
            $table->foreign('registered_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
        });
    }
};
