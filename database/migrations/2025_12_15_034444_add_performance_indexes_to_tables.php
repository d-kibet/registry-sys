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
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            // email - already indexed via unique constraint
            $table->index('phone');
            // company_id - already indexed in base migration
            // is_active - already indexed in base migration
            $table->index(['company_id', 'is_active']); // Composite for filtering active users by company
            $table->index('created_at');
        });

        // Members table indexes
        Schema::table('members', function (Blueprint $table) {
            // phone_number - already indexed in base migration
            $table->index('id_number'); // For duplicate detection
            // company_id, registered_by, constituency_id - already indexed via foreign keys
            $table->index('is_verified'); // For filtering verified members
            $table->index(['company_id', 'created_at']); // For company reports by date
            $table->index(['registered_by', 'created_at']); // For agent performance reports
            $table->index(['constituency_id', 'created_at']); // For constituency reports
            $table->index('created_at'); // For general date filtering
        });

        // Companies table indexes
        Schema::table('companies', function (Blueprint $table) {
            // email - already indexed via unique constraint
            $table->index('phone');
            // is_active - already indexed in base migration
            $table->index('created_at');
        });

        // Constituencies table indexes
        Schema::table('constituencies', function (Blueprint $table) {
            // county - already indexed in base migration
            // name - already indexed via unique constraint
            $table->index(['county', 'name']); // Composite for lookups
        });

        // Audit logs table indexes
        Schema::table('audit_logs', function (Blueprint $table) {
            // user_id - already indexed in base migration
            $table->index('action'); // For filtering by action type
            // auditable_type - already indexed individually in base migration
            $table->index('auditable_id'); // For finding specific model audits
            // ['auditable_type', 'auditable_id'] - already indexed as composite in base migration
            // created_at - already indexed in base migration
            $table->index(['user_id', 'created_at']); // For user activity timeline
        });

        // Company-Constituency pivot table indexes (already have indexes from foreign keys)
        // No additional indexes needed
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['phone']);
            $table->dropIndex(['company_id', 'is_active']);
            $table->dropIndex(['created_at']);
        });

        // Members table indexes
        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex(['id_number']);
            $table->dropIndex(['is_verified']);
            $table->dropIndex(['company_id', 'created_at']);
            $table->dropIndex(['registered_by', 'created_at']);
            $table->dropIndex(['constituency_id', 'created_at']);
            $table->dropIndex(['created_at']);
        });

        // Companies table indexes
        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex(['phone']);
            $table->dropIndex(['created_at']);
        });

        // Constituencies table indexes
        Schema::table('constituencies', function (Blueprint $table) {
            $table->dropIndex(['county', 'name']);
        });

        // Audit logs table indexes
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropIndex(['action']);
            $table->dropIndex(['auditable_id']);
            $table->dropIndex(['user_id', 'created_at']);
        });

        // Company-Constituency pivot table indexes (no additional indexes to drop)
    }
};
