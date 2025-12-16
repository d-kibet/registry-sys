-- Production Permission Fixes for PostgreSQL
-- Run this as database owner/superuser to add missing constraints and indexes
--
-- Usage: psql -U postgres -d your_database_name -f production_permission_fixes.sql

\echo ''
\echo '========================================='
\echo 'Production Database Permission Fixes'
\echo '========================================='
\echo ''

-- Start transaction for safety
BEGIN;

\echo 'Adding unique constraint to users.phone...'
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.table_constraints
        WHERE table_name = 'users'
        AND constraint_type = 'UNIQUE'
        AND constraint_name = 'users_phone_unique'
    ) THEN
        ALTER TABLE users ADD CONSTRAINT users_phone_unique UNIQUE (phone);
        RAISE NOTICE 'Added unique constraint to users.phone';
    ELSE
        RAISE NOTICE 'Unique constraint users_phone_unique already exists';
    END IF;
END $$;

\echo ''
\echo 'Adding performance indexes to users table...'

CREATE INDEX IF NOT EXISTS users_phone_index ON users(phone);
CREATE INDEX IF NOT EXISTS users_company_id_is_active_index ON users(company_id, is_active);
CREATE INDEX IF NOT EXISTS users_created_at_index ON users(created_at);

\echo 'Done with users table.'
\echo ''
\echo 'Adding performance indexes to members table...'

CREATE INDEX IF NOT EXISTS members_id_number_index ON members(id_number);
CREATE INDEX IF NOT EXISTS members_is_verified_index ON members(is_verified);
CREATE INDEX IF NOT EXISTS members_company_id_created_at_index ON members(company_id, created_at);
CREATE INDEX IF NOT EXISTS members_registered_by_created_at_index ON members(registered_by, created_at);
CREATE INDEX IF NOT EXISTS members_constituency_id_created_at_index ON members(constituency_id, created_at);
CREATE INDEX IF NOT EXISTS members_created_at_index ON members(created_at);

\echo 'Done with members table.'
\echo ''
\echo 'Adding performance indexes to companies table...'

CREATE INDEX IF NOT EXISTS companies_phone_index ON companies(phone);
CREATE INDEX IF NOT EXISTS companies_created_at_index ON companies(created_at);

\echo 'Done with companies table.'
\echo ''
\echo 'Adding performance indexes to constituencies table...'

CREATE INDEX IF NOT EXISTS constituencies_county_name_index ON constituencies(county, name);

\echo 'Done with constituencies table.'
\echo ''
\echo 'Adding performance indexes to audit_logs table...'

CREATE INDEX IF NOT EXISTS audit_logs_action_index ON audit_logs(action);
CREATE INDEX IF NOT EXISTS audit_logs_auditable_id_index ON audit_logs(auditable_id);
CREATE INDEX IF NOT EXISTS audit_logs_user_id_created_at_index ON audit_logs(user_id, created_at);

\echo 'Done with audit_logs table.'
\echo ''

-- Commit transaction
COMMIT;

\echo ''
\echo '========================================='
\echo 'All fixes applied successfully!'
\echo '========================================='
\echo ''
\echo 'Summary of changes:'
\echo '  - Added unique constraint to users.phone'
\echo '  - Added 3 performance indexes to users'
\echo '  - Added 6 performance indexes to members'
\echo '  - Added 2 performance indexes to companies'
\echo '  - Added 1 performance index to constituencies'
\echo '  - Added 3 performance indexes to audit_logs'
\echo ''
\echo 'Your database is now fully optimized!'
\echo ''

-- Display current indexes for verification
\echo 'Verifying indexes on key tables:'
\echo ''
\echo 'Users table indexes:'
SELECT indexname, indexdef FROM pg_indexes WHERE tablename = 'users' AND schemaname = 'public';

\echo ''
\echo 'Members table indexes:'
SELECT indexname, indexdef FROM pg_indexes WHERE tablename = 'members' AND schemaname = 'public';

\echo ''
\echo 'Constraints on users table:'
SELECT constraint_name, constraint_type FROM information_schema.table_constraints
WHERE table_name = 'users' AND constraint_type IN ('UNIQUE', 'PRIMARY KEY', 'FOREIGN KEY');
