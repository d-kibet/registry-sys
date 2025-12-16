# Storage Setup for Hosted Server

This guide helps you configure file storage on your hosted server when `php artisan storage:link` doesn't work.

## The Problem
Your hosting provider has disabled the `exec()` and `symlink()` PHP functions, preventing Laravel's automatic storage link creation.

## ✅ SOLUTION 1: Route-Based File Serving (ALREADY CONFIGURED)

**Your application now serves files via routes - no symlink needed!**

Files are automatically served through: `/storage/{path}`

### How it works:
- Verification proof images are stored in: `storage/app/public/verification_proofs/`
- They're accessible via: `https://yourdomain.com/storage/verification_proofs/filename.jpg`
- The route handles authentication and proper MIME types
- Files are cached for better performance

### ✅ No action needed - this is already working!

---

## SOLUTION 2: Manual Symbolic Link via SSH

If you have SSH access to your server:

```bash
# Navigate to your application root
cd /path/to/your/application

# Create the symbolic link
ln -s /path/to/your/application/storage/app/public /path/to/your/application/public/storage

# Verify it was created
ls -la public/storage
```

**Example for typical cPanel hosting:**
```bash
cd ~/public_html
ln -s ~/public_html/storage/app/public ~/public_html/public/storage
```

---

## SOLUTION 3: Using cPanel File Manager

If you have cPanel access:

1. **Login to cPanel**
2. **Open File Manager**
3. Navigate to your `public` folder (usually `public_html/public`)
4. Right-click in empty space → **Create New** → **Symbolic Link**
5. Fill in the form:
   - **Link Name**: `storage`
   - **Target**: `../storage/app/public`
6. Click **Create Link**

---

## SOLUTION 4: Custom Artisan Command

I've created a custom command that tries multiple methods:

```bash
php artisan storage:link-manual
```

This command will:
1. Try to create a symbolic link using `symlink()`
2. Try using `exec()` as fallback
3. If both fail, provide detailed instructions

---

## SOLUTION 5: .htaccess Rewrite (cPanel/Apache Only)

Create a `.htaccess` file in `public/storage/` with:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /storage/
    RewriteRule ^(.*)$ ../../storage/app/public/$1 [L]
</IfModule>
```

**Steps:**
1. Create folder: `public/storage/`
2. Create file: `public/storage/.htaccess`
3. Add the rewrite rule above
4. Ensure your `storage/app/public/` exists

---

## Verification

To verify storage is working:

### 1. Check Routes
```bash
php artisan route:list | grep storage
```

You should see: `GET /storage/{path}`

### 2. Test Upload
1. Login as an agent
2. Register a member with a verification photo
3. View the registration in "All Registrations"
4. The photo should display correctly

### 3. Check Permissions
```bash
# Ensure storage directories are writable
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## Current Configuration

✅ **Route-based serving**: Enabled at `routes/web.php:25-38`
✅ **Authentication**: Required for accessing files
✅ **Caching**: Files cached for 1 year
✅ **MIME types**: Automatically detected
✅ **Path traversal protection**: Built-in

---

## Troubleshooting

### Images not displaying?

**Check 1: Storage directory exists**
```bash
ls -la storage/app/public/verification_proofs/
```

**Check 2: Files uploaded successfully**
```bash
ls -la storage/app/public/verification_proofs/
```
Should show your uploaded images.

**Check 3: Route is working**
Visit: `https://yourdomain.com/storage/verification_proofs/test.jpg`
(after uploading a test image)

### Permission Errors?

```bash
# Set correct ownership (replace 'youruser' with your hosting username)
chown -R youruser:youruser storage/
chown -R youruser:youruser bootstrap/cache/

# Set correct permissions
find storage/ -type d -exec chmod 775 {} \;
find storage/ -type f -exec chmod 664 {} \;
find bootstrap/cache/ -type d -exec chmod 775 {} \;
find bootstrap/cache/ -type f -exec chmod 664 {} \;
```

### Symlink creation fails with "Function not found"?

✅ **No problem!** Your app uses route-based serving (Solution 1).
The symlink is optional when routes handle file serving.

---

## Deployment Checklist for Hosted Server

- [ ] Upload all files via FTP/SFTP
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set permissions on `storage/` and `bootstrap/cache/`
- [ ] Configure `.env` file with production settings
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Test file uploads and viewing
- [ ] (Optional) Create storage symlink using one of the solutions above

---

## Recommended: Route-Based Serving

**I recommend using the route-based solution (Solution 1)** because:

✅ Works on any hosting environment
✅ No symlink required
✅ Built-in authentication
✅ Better security (no direct file access)
✅ Proper MIME type handling
✅ Easy caching control
✅ Works with restrictive PHP configurations

**This is already configured and ready to use!**

---

## Need Help?

If you encounter issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check server error logs (usually in cPanel or via SSH)
3. Verify file permissions
4. Ensure PHP version is 8.2+ with required extensions

---

Generated: <?php echo date('Y-m-d H:i:s'); ?>
