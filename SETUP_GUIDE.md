# 🚀 Panduan Setup Environment

## Persiapan Awal

### 1. Install Software yang Dibutuhkan

#### Windows
- **XAMPP** atau **Laragon** (sudah include PHP, MySQL, Apache)
  - Download: https://www.apachefriends.org/
  - Atau Laragon: https://laragon.org/

- **Composer**
  - Download: https://getcomposer.org/download/
  - Install secara global

- **Node.js & NPM**
  - Download: https://nodejs.org/
  - Pilih versi LTS

#### Linux/Mac
```bash
# Install PHP 8.2+
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt install -y nodejs

# Install MySQL
sudo apt install mysql-server
```

---

## Setup Project

### 1. Clone atau Download Project
```bash
# Jika menggunakan Git
git clone <repository-url>
cd keuangan-analitik

# Atau ekstrak ZIP file
unzip keuangan-analitik.zip
cd keuangan-analitik
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment File
```bash
# Copy file .env.example menjadi .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:
```env
APP_NAME="Sistem Analitik Keuangan"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_analitik_keuangan
DB_USERNAME=root
DB_PASSWORD=

# Jika menggunakan XAMPP, password biasanya kosong
# Jika menggunakan password: DB_PASSWORD=your_password
```

### 5. Buat Database

#### Via MySQL Command Line
```bash
mysql -u root -p
```
```sql
CREATE DATABASE sistem_analitik_keuangan;
EXIT;
```

#### Via phpMyAdmin
1. Buka `http://localhost/phpmyadmin`
2. Klik tab "Database"
3. Masukkan nama: `sistem_analitik_keuangan`
4. Klik "Create"

### 6. Jalankan Migration & Seeder

Jalankan migration untuk membuat tabel dan seeder untuk data awal:
```bash
php artisan migrate
php artisan db:seed
```

Atau jalankan sekaligus:
```bash
php artisan migrate --seed
```

Seeder akan membuat:
- 1 Admin: admin@analitik.com / admin123
- 1 Manager: manager@analitik.com / manager123
- 2 Staff: staff@analitik.com & staff2@analitik.com / staff123
- 3 Sample financial reports (pending, approved, rejected)
- 6 Sample transactions

### 7. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 9. Run Server
```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## Verifikasi Instalasi

### 1. Cek Halaman Login
- Buka `http://localhost:8000`
- Pastikan halaman login muncul

### 2. Test Login Admin
- Email: `admin@analitik.com`
- Password: `admin123`
- Klik Login
- Pastikan redirect ke dashboard admin

### 3. Cek Database Connection
```bash
php artisan tinker
```
```php
\App\Models\User::count();
// Output: 4 (jika menggunakan data seed)
exit
```

---

## Troubleshooting

### Error: SQLSTATE[HY000] [2002] Connection refused
**Solusi**:
- Pastikan MySQL sudah running
- Cek credential database di `.env`
- Start XAMPP/Laragon MySQL service

### Error: Class 'Composer\...' not found
**Solusi**:
```bash
composer dump-autoload
```

### Error: Mix file not found
**Solusi**:
```bash
npm run build
```

### Error: Storage link not working
**Solusi**:
```bash
php artisan storage:link
```

### Error: Permission denied (Linux/Mac)
**Solusi**:
```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Port 8000 already in use
**Solusi**:
```bash
# Gunakan port lain
php artisan serve --port=8080
```

---

## Mode Development

### Watch for Changes (Hot Reload)
```bash
npm run dev
```
Biarkan terminal ini tetap berjalan saat development.

### Clear All Cache
```bash
php artisan optimize:clear
```

### Regenerate Autoload
```bash
composer dump-autoload
```

---

## Production Deployment

### 1. Set Environment
Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

### 2. Optimize Laravel
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Build Assets
```bash
npm run build
```

### 4. Set Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 5. Setup Web Server (Apache)
Edit Virtual Host:
```apache
<VirtualHost *:80>
    ServerName analitik-keuangan.local
    DocumentRoot "/path/to/keuangan-analitik/public"
    
    <Directory "/path/to/keuangan-analitik/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 6. Setup Web Server (Nginx)
```nginx
server {
    listen 80;
    server_name analitik-keuangan.local;
    root /path/to/keuangan-analitik/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## Update Aplikasi

Jika ada update dari repository:

```bash
# Pull update
git pull origin main

# Update dependencies
composer install
npm install

# Migrate database (jika ada perubahan)
php artisan migrate

# Build assets
npm run build

# Clear cache
php artisan optimize:clear
```

---

## Backup Database

### Manual Backup
```bash
# Backup
mysqldump -u root -p sistem_analitik_keuangan > backup_$(date +%Y%m%d).sql

# Restore
mysql -u root -p sistem_analitik_keuangan < backup_20251208.sql
```

### Automated Backup (Linux Cron)
```bash
# Edit crontab
crontab -e

# Tambahkan (backup setiap hari jam 2 pagi)
0 2 * * * mysqldump -u root -p sistem_analitik_keuangan > /path/to/backup/db_$(date +\%Y\%m\%d).sql
```

---

## Environment Variables Reference

```env
# Application
APP_NAME="Sistem Analitik Keuangan"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_analitik_keuangan
DB_USERNAME=root
DB_PASSWORD=

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Cache
CACHE_DRIVER=file

# Queue
QUEUE_CONNECTION=sync

# Mail (if needed)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@analitik.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Checklist Instalasi

- [ ] PHP 8.2+ terinstall
- [ ] Composer terinstall
- [ ] Node.js & NPM terinstall
- [ ] MySQL/MariaDB terinstall
- [ ] Project di-clone/download
- [ ] Dependencies terinstall (composer + npm)
- [ ] File .env dibuat dan dikonfigurasi
- [ ] Database dibuat
- [ ] Data diimport (SQL atau migration)
- [ ] Assets di-build (npm run build)
- [ ] Server berjalan (php artisan serve)
- [ ] Login berhasil
- [ ] Dashboard muncul dengan data

---

## Contact

Jika masih ada masalah:
- Dokumentasi: Lihat `DOKUMENTASI_ADMIN.md`
- Email: support@analitik.com
- Issue: GitHub Issues

Selamat menggunakan Sistem Analitik Keuangan! 🎉
