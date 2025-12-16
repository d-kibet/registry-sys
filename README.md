# UDA Agent Registration Platform

A comprehensive multi-tenant agent registration platform built for the Kenyan market using Laravel 11 and PostgreSQL. This system enables authorized companies to register agents who collect UDA member registrations in the field, with full offline capability and real-time duplicate detection.

## 🎯 System Overview

The platform serves three distinct user roles:
- **Super Admin**: Full platform access, manages all companies and views all data
- **Company Admin**: Manages their company's agents, views registrations, and exports reports
- **Agent**: Registers members in the field (offline-capable) and views personal stats

## ✨ Key Features

### Multi-Tenancy & User Management
- Complete company isolation
- Role-based access control using Spatie Laravel Permission
- Company admins can create and manage agents (agents cannot self-register)
- User activation/deactivation functionality

### Member Registration
- **Required Fields**:
  - Full Name
  - Phone Number (Kenyan format with validation)
  - ID Number (National ID or Passport)
  - Gender (Male, Female, Prefer not to say)
  - Polling Station
  - Ward
  - Constituency (290 Kenya constituencies preloaded)
  - Verification Proof (Image upload with validation)
- **Optional Fields**:
  - GPS Coordinates (auto-captured if available)

### Offline Capability (PWA)
- Progressive Web App with service workers *(pending implementation)*
- Register members without internet connection
- Data stored in IndexedDB/LocalStorage
- Auto-sync when connection restored
- Clear sync status indicators

### Duplicate Detection
- Real-time phone number validation *(pending implementation)*
- Shows: "This phone number is already registered on [date] by [agent name] from [company name]"
- Prevents duplicate submissions across entire platform

### Security Features
- Laravel Sanctum authentication
- CSRF protection
- Rate limiting on registration endpoints
- Secure file uploads with MIME type validation
- Session timeout after 30 minutes
- Comprehensive audit logging

### Performance Optimization
- File-based caching for shared hosting compatibility
- Database indexing on frequently queried fields
- Lazy loading for images
- Pagination (20 records per page)
- Debounced search inputs
- Client-side image compression (max 2MB)
- Query optimization with eager loading

### Reporting & Export
- CSV/Excel export functionality *(pending implementation)*
- Company-specific reports
- Agent performance dashboards
- Date range filtering
- Search and advanced filters

### Kenyan Localization
- All 290 constituencies preloaded and organized by county
- Phone validation for Safaricom, Airtel, Telkom Kenya
- Timezone: Africa/Nairobi
- Date format: DD/MM/YYYY

## 🛠️ Technical Stack

- **Backend**: Laravel 11
- **Database**: PostgreSQL with comprehensive indexing
- **Frontend**: Livewire 3 + Alpine.js + Tailwind CSS
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **File Management**: Intervention Image for optimization
- **Import/Export**: Laravel Excel (Maatwebsite)
- **Cache**: File-based (shared hosting compatible)
- **Design**: Yellow & Green color scheme (UDA colors)

## 📋 Requirements

- PHP >= 8.2
- PostgreSQL >= 12
- Composer
- Node.js & NPM
- Extensions: pdo_pgsql, gd, imagick (optional)

## 🚀 Installation

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration

Update PostgreSQL settings in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=cdf_registration
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

### 3. Database Setup

```bash
# Create the database (PostgreSQL command)
createdb cdf_registration

# Or using psql
psql -U postgres
CREATE DATABASE cdf_registration;
\q

# Run migrations
php artisan migrate

# Seed the database (creates roles, constituencies, and Super Admin)
php artisan db:seed
```

### 4. Build Frontend Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 5. Storage Setup

```bash
# Create symbolic link for file uploads
php artisan storage:link
```

### 6. Start Development Server

```bash
# Start Laravel server
php artisan serve

# In another terminal, start Vite
npm run dev
```

Visit `http://localhost:8000`

## 🔐 Default Credentials

After running the seeders, you can log in with:

**Super Admin**
- Email: `admin@udaregistry.ke`
- Password: `Admin@2025`
- Phone: `0780222690`

⚠️ **IMPORTANT**: Change these credentials immediately after first login!

## 📊 Database Structure

### Tables Created

1. **companies** - Authorized companies in the system
2. **users** - All system users (Super Admin, Company Admins, Agents)
3. **members** - Registered UDA members
4. **constituencies** - All 290 Kenya constituencies
5. **audit_logs** - Comprehensive audit trail
6. **roles & permissions** - Spatie permission tables

For detailed schema information, see the migrations in `database/migrations/`.

## 👥 User Roles & Permissions

### Super Admin
- Full system access
- Manage all companies
- View all registrations
- System-wide reports

### Company Admin
- Manage company agents (create, edit, suspend)
- View company registrations
- Export company data
- Generate company reports

### Agent
- Register members (with offline support)
- View own registrations
- View personal performance stats

## 📁 Project Structure

```
app/Models/          # All Eloquent models with relationships
database/
  migrations/        # Database schema definitions
  seeders/           # Data seeders (roles, constituencies, admin)
resources/           # Views, CSS, JS (to be implemented)
public/storage/      # Uploaded verification proofs
```

## 🎨 Design System

**Color Scheme** (UDA Colors):
- Primary: Yellow
- Secondary: Green
- Implementation pending in Tailwind configuration

## ✅ Completed Features

- ✅ Laravel 11 project setup
- ✅ PostgreSQL database configuration
- ✅ Database migrations (companies, users, members, constituencies, audit_logs)
- ✅ Eloquent models with relationships
- ✅ Spatie permissions setup (3 roles, 25+ permissions)
- ✅ 290 Kenya constituencies seeded
- ✅ Initial Super Admin user
- ✅ Audit logging system
- ✅ Multi-tenant architecture
- ✅ Session timeout configuration (30 minutes)
- ✅ File-based caching for shared hosting

## 🔄 Pending Implementation

1. **Authentication System** - Login, logout, role-based redirects
2. **Livewire Components** - All panels (Super Admin, Company Admin, Agent)
3. **Duplicate Detection** - Real-time phone number validation
4. **PWA Implementation** - Service workers, offline storage, sync
5. **Export/Import** - CSV/Excel functionality
6. **UI Design** - Yellow & Green themed responsive interface
7. **Phone Validation** - Kenyan network format validation
8. **Image Upload** - Verification proof handling
9. **GPS Integration** - Auto-capture coordinates
10. **Reports & Dashboards** - Performance analytics

## 🐛 Troubleshooting

### Migration Errors
```bash
php artisan migrate:fresh
php artisan db:seed
```

### Permission Issues
```bash
php artisan permission:cache-reset
php artisan cache:clear
```

### File Upload Issues
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

## 🔒 Security Best Practices

1. Change default credentials immediately
2. Use strong passwords (min 12 characters)
3. Enable HTTPS in production
4. Set proper file permissions
5. Keep Laravel and packages updated
6. Use environment variables for sensitive data
7. Enable rate limiting on public endpoints
8. Regular database backups

## 🚀 Production Deployment

### Shared Hosting Setup

1. Upload files to public_html or www folder
2. Move .env outside web root for security
3. Update .env with production database credentials
4. Run migrations on production database
5. Build assets: `npm run build`
6. Set permissions: `chmod -R 755 storage bootstrap/cache`
7. Clear caches:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

**Built with ❤️ for the Kenyan market using Laravel 11**

*Last Updated: December 14, 2025*
