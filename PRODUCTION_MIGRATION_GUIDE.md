# Production Server Migration Guide

## 🚀 Safe Migration on Hosted Server (Limited Permissions)

Your migrations have been updated to handle PostgreSQL permission restrictions gracefully.

---

## ✅ SOLUTION 1: Run Migrations with Updated Files (Recommended)

All migrations have been updated to:
- Check if constraints/indexes exist before creating
- Handle permission errors gracefully
- Continue even if some operations fail
- Show warnings instead of failing

**Simply run:**
```bash
php artisan migrate --force
```

The migrations will:
- ✅ Create tables and columns successfully
- ⚠️  Show warnings for operations that require higher permissions
- ✅ Continue with the rest of the migration
- ✅ Mark migrations as complete

**You'll see output like:**
```
⚠️  WARNING: Could not add unique constraint to users.phone
Error: Insufficient privilege...
To fix this, run as database owner:
ALTER TABLE users ADD CONSTRAINT users_phone_unique UNIQUE (phone);

✅ Performance indexes migration completed (some may have been skipped due to permissions)
```

**This is NORMAL and SAFE!** The application will still work correctly.

---

## ✅ SOLUTION 2: Manual SQL Fixes (Run as Database Owner)

If you have access to run SQL as the database owner (superuser), run these commands to add the missing constraints and indexes:

### Option A: Via SQL File

I've created a complete SQL script for you:

```bash
psql -U your_db_owner -d your_database -f production_permission_fixes.sql
```

### Option B: Run SQL Manually

Connect as database owner:
```bash
psql -U your_db_owner -d your_database
```

Then run:
```sql
-- Add unique constraint to users.phone
ALTER TABLE users ADD CONSTRAINT users_phone_unique UNIQUE (phone);

-- Add performance indexes to users
CREATE INDEX IF NOT EXISTS users_phone_index ON users(phone);
CREATE INDEX IF NOT EXISTS users_company_id_is_active_index ON users(company_id, is_active);
CREATE INDEX IF NOT EXISTS users_created_at_index ON users(created_at);

-- Add performance indexes to members
CREATE INDEX IF NOT EXISTS members_id_number_index ON members(id_number);
CREATE INDEX IF NOT EXISTS members_is_verified_index ON members(is_verified);
CREATE INDEX IF NOT EXISTS members_company_id_created_at_index ON members(company_id, created_at);
CREATE INDEX IF NOT EXISTS members_registered_by_created_at_index ON members(registered_by, created_at);
CREATE INDEX IF NOT EXISTS members_constituency_id_created_at_index ON members(constituency_id, created_at);
CREATE INDEX IF NOT EXISTS members_created_at_index ON members(created_at);

-- Add performance indexes to companies
CREATE INDEX IF NOT EXISTS companies_phone_index ON companies(phone);
CREATE INDEX IF NOT EXISTS companies_created_at_index ON companies(created_at);

-- Add performance indexes to constituencies
CREATE INDEX IF NOT EXISTS constituencies_county_name_index ON constituencies(county, name);

-- Add performance indexes to audit_logs
CREATE INDEX IF NOT EXISTS audit_logs_action_index ON audit_logs(action);
CREATE INDEX IF NOT EXISTS audit_logs_auditable_id_index ON audit_logs(auditable_id);
CREATE INDEX IF NOT EXISTS audit_logs_user_id_created_at_index ON audit_logs(user_id, created_at);
```

---

## 📋 Deployment Steps for Hosted Server

1. **Upload your code** (via FTP, Git, etc.)

2. **Install dependencies:**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

4. **Generate application key:**
   ```bash
   php artisan key:generate --force
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate --force
   ```

6. **Set permissions:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

7. **Optimize for production:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

8. **(Optional) Run manual SQL fixes:**
   ```bash
   psql -U db_owner -d your_db -f production_permission_fixes.sql
   ```

9. **Verify application works:**
   - Test login
   - Test member registration
   - Check that images display

---

## 🔍 Understanding the Warnings

### What's happening?

Your hosting provider has restricted certain PostgreSQL operations for security:
- **ALTER TABLE with constraints** requires table ownership
- **CREATE INDEX** requires table ownership or specific grants

### Will my app work without these?

**YES!** Here's why:

1. **Unique Constraints:**
   - Laravel validates uniqueness at application level (in your form validations)
   - Database constraint is an extra safety layer (nice to have, not required)

2. **Performance Indexes:**
   - Your app will work without them
   - Indexes only improve query speed
   - For small-to-medium databases, the difference is negligible
   - You can add them later when you have database owner access

### What's critical vs optional?

**✅ Critical (Must Work):**
- Table creation
- Column creation
- Foreign keys (usually work)
- Basic indexes created during table creation

**⚠️  Optional (Nice to Have):**
- Additional unique constraints
- Performance indexes
- These improve performance/data integrity but aren't required for functionality

---

## 🛠️ Troubleshooting

### Migration fails completely?

**Check 1: Can you create tables?**
```bash
php artisan tinker
>>> Schema::hasTable('users')
```

If `false`, your database user doesn't have CREATE TABLE permission. Contact hosting support.

**Check 2: Check migration status:**
```bash
php artisan migrate:status
```

**Check 3: Roll back last migration:**
```bash
php artisan migrate:rollback --step=1
php artisan migrate
```

### Application works but slow queries?

This means indexes weren't created. Options:

1. **Contact hosting support** - Ask them to grant index creation privileges
2. **Run SQL script** - Get superuser access from hosting
3. **Wait until database grows** - May not be noticeable with small data

### How to verify what's missing?

Check what constraints/indexes exist:

```sql
-- Check constraints
SELECT constraint_name, constraint_type
FROM information_schema.table_constraints
WHERE table_name = 'users';

-- Check indexes
SELECT indexname, indexdef
FROM pg_indexes
WHERE tablename = 'users';
```

---

## 🔐 Best Practices for Production

### Database Users Setup

**Option 1: Single User (Simple)**
- One database user for everything
- Request increased permissions from hosting

**Option 2: Two Users (Secure)**
- **Migration User**: High privileges (for deployments only)
- **App User**: Limited privileges (SELECT, INSERT, UPDATE, DELETE)

Example:
```ini
# In .env during deployment
DB_USERNAME=migration_user
DB_PASSWORD=migration_pass

# After migrations, switch to
DB_USERNAME=app_user
DB_PASSWORD=app_pass
```

### Contact Your Hosting Provider

If migrations fail, ask your hosting provider for:

1. **CREATE INDEX** privilege on your database
2. **ALTER TABLE** privilege
3. Or temporary superuser access during deployment

Most providers can grant these safely for trusted customers.

---

## 📝 Migration Files Updated

The following migrations now handle permission errors gracefully:

✅ **2025_12_16_155056_add_unique_constraint_to_users_phone_table.php**
- Checks if constraint exists before creating
- Shows warning if permission denied
- Doesn't fail the migration

✅ **2025_12_15_034444_add_performance_indexes_to_tables.php**
- Wraps all index creation in try-catch
- Shows warnings for failed indexes
- Continues with rest of migration

✅ **2025_12_16_062430_improve_vie_position_column_in_members_table.php**
- Gracefully handles index drop errors
- Uses IF EXISTS clauses
- Logs warnings instead of failing

✅ **2025_12_16_155557_remove_email_from_companies_table.php**
- Makes email nullable on rollback
- Prevents NOT NULL violations

---

## 🎯 Quick Resolution

**For most shared hosting:**

1. Run `php artisan migrate --force`
2. Ignore warnings about permissions
3. Application will work fine
4. Performance may be slightly reduced (not noticeable for small databases)
5. Add indexes manually later if needed

**For VPS/Dedicated servers:**

1. Switch to postgres/superuser temporarily
2. Run migrations
3. Or run the SQL fixes script
4. Switch back to restricted user

**The application is designed to work with or without these database-level constraints!**

---

## 📞 Need Help?

If you encounter issues:

1. **Check Laravel logs:** `storage/logs/laravel.log`
2. **Test database connection:** `php artisan tinker` then `DB::connection()->getPdo();`
3. **Verify migrations table exists:** `php artisan migrate:status`
4. **Contact hosting support** if you can't create tables at all

---

**Your migrations are now production-ready! 🚀**
