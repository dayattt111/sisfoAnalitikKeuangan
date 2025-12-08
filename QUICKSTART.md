# ⚡ QUICK START GUIDE

## Panduan Cepat Memulai Sistem Analitik Keuangan

---

## 📌 Prasyarat

✅ PHP 8.2+  
✅ Composer  
✅ Node.js & NPM  
✅ MySQL/MariaDB  
✅ XAMPP/Laragon (Windows) atau LAMP/LEMP (Linux)

---

## 🚀 Instalasi Cepat (5 Menit)

### 1️⃣ Clone/Download Project
```bash
cd /path/to/your/projects
# Extract project jika dalam bentuk ZIP
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_DATABASE=sistem_analitik_keuangan
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Buat & Import Database
```bash
# Buat database
mysql -u root -p -e "CREATE DATABASE sistem_analitik_keuangan;"

# Import data
mysql -u root -p sistem_analitik_keuangan < database/sistem_analitik_keuangan.sql
```

### 5️⃣ Build & Run
```bash
npm run build
php artisan serve
```

### 6️⃣ Login
Buka: `http://localhost:8000`

**Admin:**
- Email: `admin@analitik.com`
- Password: `admin123`

---

## 🎯 Fitur Admin

| Menu | Fungsi | URL |
|------|--------|-----|
| 📊 Dashboard | Statistik & Overview | `/admin/dashboard` |
| 👥 Kelola User | CRUD Pengguna | `/admin/users` |
| 📋 Validasi Laporan | Approve/Reject Laporan | `/admin/reports` |
| 📜 Monitoring | Log Aktivitas | `/admin/activity-logs` |

---

## 🔧 Troubleshooting Cepat

### Database Error?
```bash
# Cek MySQL running
# Windows: Buka XAMPP Control Panel
# Linux: sudo systemctl status mysql

# Test koneksi
php artisan tinker
>>> \App\Models\User::count();
```

### Assets Tidak Muncul?
```bash
npm run build
php artisan optimize:clear
```

### Permission Error (Linux)?
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📚 Dokumentasi Lengkap

- 📖 **Admin**: `DOKUMENTASI_ADMIN.md`
- 🛠️ **Setup**: `SETUP_GUIDE.md`
- 📋 **Project**: `README_PROJECT.md`
- ✅ **Summary**: `SUMMARY.md`

---

## 💡 Tips

1. **Ganti Password**: Segera ubah password default setelah login pertama
2. **Backup Database**: Gunakan `mysqldump` untuk backup rutin
3. **Clear Cache**: Jalankan `php artisan optimize:clear` jika ada perubahan
4. **Development Mode**: Gunakan `npm run dev` untuk hot reload

---

## 🆘 Butuh Bantuan?

- 📖 Baca `SETUP_GUIDE.md` untuk panduan detail
- 📧 Email: support@analitik.com
- 📝 Cek `DOKUMENTASI_ADMIN.md` untuk panduan fitur

---

## ✅ Checklist

- [ ] Dependencies terinstall
- [ ] Database dibuat & diimport
- [ ] `.env` dikonfigurasi
- [ ] Assets di-build
- [ ] Server berjalan
- [ ] Login berhasil
- [ ] Dashboard muncul

Jika semua ✅, aplikasi siap digunakan! 🎉

---

**Quick Support**:
```bash
# Cek versi PHP
php -v

# Cek versi Composer
composer --version

# Cek versi Node
node -v

# Test server
php artisan serve

# Clear semua cache
php artisan optimize:clear
```

Selamat menggunakan! 🚀
