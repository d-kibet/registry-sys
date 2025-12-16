-- Fix PostgreSQL Database Permissions for Migrations
-- Run this as the database superuser or owner

-- Replace 'your_database_name' with your actual database name
-- Replace 'your_app_user' with your Laravel application database user

\c your_database_name;

-- Grant ownership of all tables in public schema to your app user
-- Option 1: If you want to transfer ownership completely
-- ALTER TABLE members OWNER TO your_app_user;
-- ALTER TABLE users OWNER TO your_app_user;
-- ALTER TABLE companies OWNER TO your_app_user;
-- ALTER TABLE constituencies OWNER TO your_app_user;
-- ALTER TABLE company_constituency OWNER TO your_app_user;
-- ALTER TABLE migrations OWNER TO your_app_user;
-- ALTER TABLE roles OWNER TO your_app_user;
-- ALTER TABLE role_user OWNER TO your_app_user;
-- ALTER TABLE audit_logs OWNER TO your_app_user;

-- Option 2: Grant privileges without changing ownership
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO your_app_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO your_app_user;

-- Allow dropping indexes
GRANT ALL ON SCHEMA public TO your_app_user;

-- Fix the specific index causing issues
ALTER INDEX IF EXISTS members_vie_position_index OWNER TO your_app_user;

-- Grant privileges on all existing indexes
DO $$
DECLARE
    index_record RECORD;
BEGIN
    FOR index_record IN
        SELECT indexname
        FROM pg_indexes
        WHERE schemaname = 'public'
    LOOP
        BEGIN
            EXECUTE 'ALTER INDEX IF EXISTS ' || quote_ident(index_record.indexname) || ' OWNER TO your_app_user';
        EXCEPTION WHEN OTHERS THEN
            RAISE NOTICE 'Could not change ownership of index %', index_record.indexname;
        END;
    END LOOP;
END $$;

-- Verify permissions
\dp members
\di members_vie_position_index
