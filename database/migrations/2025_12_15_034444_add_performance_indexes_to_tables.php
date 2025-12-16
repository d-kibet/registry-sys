<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Helper function to safely add index
     */
    private function safelyAddIndex($table, $columns, $indexName = null)
    {
        $tableName = is_string($table) ? $table : 'unknown';
        $columnList = is_array($columns) ? implode(', ', $columns) : $columns;

        try {
            if (is_callable($table)) {
                Schema::table($tableName, $table);
            } else {
                Schema::table($table, function (Blueprint $t) use ($columns) {
                    $t->index($columns);
                });
            }
        } catch (\Exception $e) {
            echo "⚠️  Could not add index on {$tableName}({$columnList}): " . $e->getMessage() . "\n";
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users table indexes
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->index('phone');
                $table->index(['company_id', 'is_active']);
                $table->index('created_at');
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not add indexes to users table: " . $e->getMessage() . "\n";
        }

        // Members table indexes
        try {
            Schema::table('members', function (Blueprint $table) {
                $table->index('id_number');
                $table->index('is_verified');
                $table->index(['company_id', 'created_at']);
                $table->index(['registered_by', 'created_at']);
                $table->index(['constituency_id', 'created_at']);
                $table->index('created_at');
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not add indexes to members table: " . $e->getMessage() . "\n";
        }

        // Companies table indexes
        try {
            Schema::table('companies', function (Blueprint $table) {
                $table->index('phone');
                $table->index('created_at');
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not add indexes to companies table: " . $e->getMessage() . "\n";
        }

        // Constituencies table indexes
        try {
            Schema::table('constituencies', function (Blueprint $table) {
                $table->index(['county', 'name']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not add indexes to constituencies table: " . $e->getMessage() . "\n";
        }

        // Audit logs table indexes
        try {
            Schema::table('audit_logs', function (Blueprint $table) {
                $table->index('action');
                $table->index('auditable_id');
                $table->index(['user_id', 'created_at']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not add indexes to audit_logs table: " . $e->getMessage() . "\n";
        }

        echo "✅ Performance indexes migration completed (some may have been skipped due to permissions)\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Users table indexes
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['phone']);
                $table->dropIndex(['company_id', 'is_active']);
                $table->dropIndex(['created_at']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not drop indexes from users table: " . $e->getMessage() . "\n";
        }

        // Members table indexes
        try {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndex(['id_number']);
                $table->dropIndex(['is_verified']);
                $table->dropIndex(['company_id', 'created_at']);
                $table->dropIndex(['registered_by', 'created_at']);
                $table->dropIndex(['constituency_id', 'created_at']);
                $table->dropIndex(['created_at']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not drop indexes from members table: " . $e->getMessage() . "\n";
        }

        // Companies table indexes
        try {
            Schema::table('companies', function (Blueprint $table) {
                $table->dropIndex(['phone']);
                $table->dropIndex(['created_at']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not drop indexes from companies table: " . $e->getMessage() . "\n";
        }

        // Constituencies table indexes
        try {
            Schema::table('constituencies', function (Blueprint $table) {
                $table->dropIndex(['county', 'name']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not drop indexes from constituencies table: " . $e->getMessage() . "\n";
        }

        // Audit logs table indexes
        try {
            Schema::table('audit_logs', function (Blueprint $table) {
                $table->dropIndex(['action']);
                $table->dropIndex(['auditable_id']);
                $table->dropIndex(['user_id', 'created_at']);
            });
        } catch (\Exception $e) {
            echo "⚠️  Could not drop indexes from audit_logs table: " . $e->getMessage() . "\n";
        }

        echo "✅ Performance indexes rollback completed\n";
    }
};
