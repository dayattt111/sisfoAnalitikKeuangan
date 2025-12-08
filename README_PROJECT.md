# 💼 Sistem Informasi Analitik Keuangan Bisnis

Aplikasi web berbasis Laravel untuk mengelola dan menganalisis data keuangan bisnis dengan sistem role-based (Admin, Manager, Staff).

---

## 🚀 Fitur Utama

### 👨‍💼 Admin
- ✅ Dashboard dengan statistik lengkap
- ✅ Kelola pengguna (CRUD)
- ✅ Validasi laporan keuangan
- ✅ Monitoring aktivitas sistem
- ✅ Manajemen profile

### 👔 Manager
- 📊 Dashboard manajemen keuangan
- 📈 Laporan rekapitulasi keuangan & kinerja staff
- 💰 Manajemen transaksi keuangan
- 📉 Analisis financial forecasting

### 👤 Staff
- 📝 Dashboard personal
- 💳 Input transaksi harian
- 📊 Laporan kinerja pribadi

---

## 🛠️ Teknologi

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Server**: PHP 8.2+, Apache/Nginx

---

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd keuangan-analitik
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_analitik_keuangan
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Import Database
Import file SQL yang sudah disediakan:
```bash
mysql -u root -p sistem_analitik_keuangan < database/sistem_analitik_keuangan.sql
```

Atau buat database baru dan jalankan migration + seeder:
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## 🔐 Kredensial Default

### Admin
- **Email**: admin@analitik.com
- **Password**: admin123

### Manager
- **Email**: manager@analitik.com
- **Password**: manager123

### Staff
- **Email**: staff@analitik.com
- **Password**: staff123

**⚠️ PENTING**: Segera ubah password default setelah login pertama!

---

## 📁 Struktur Direktori

```
keuangan-analitik/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── UserManagementController.php
│   │   │   │   ├── FinancialReportValidationController.php
│   │   │   │   └── ActivityLogController.php
│   │   │   ├── Manager/
│   │   │   └── Staff/
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── FinancialReport.php
│       ├── Transaction.php
│       ├── ActivityLog.php
│       └── Download.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── sistem_analitik_keuangan.sql
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── manager/
│   │   ├── staff/
│   │   └── layouts/
│   └── css/
├── routes/
│   ├── web.php
│   └── auth.php
├── DOKUMENTASI_ADMIN.md
└── README.md
```

---

## 🗄️ Schema Database

### Tabel Utama

#### `users`
- Menyimpan data pengguna (admin, manager, staff)
- Fields: id, name, email, password, role, timestamps

#### `financial_reports`
- Menyimpan laporan keuangan
- Fields: id, staff_id, validated_by, status, validated_at, timestamps
- Status: pending, approved, rejected

#### `transactions`
- Menyimpan transaksi keuangan
- Fields: id, financial_report_id, user_id, jenis, jumlah, keterangan, tanggal, timestamps
- Jenis: pemasukan, pengeluaran

#### `activity_logs`
- Menyimpan log aktivitas sistem
- Fields: id, user_id, activity, timestamps

#### `downloads`
- Menyimpan riwayat download laporan
- Fields: id, financial_report_id, user_id, file_name, file_path, downloaded_at, timestamps

---

## 🔒 Keamanan

### Authentication
- Menggunakan Laravel Breeze
- Password di-hash dengan bcrypt
- Session-based authentication
- CSRF protection

### Authorization
- Role-based access control
- Middleware untuk setiap role
- Route protection

### Activity Logging
- Semua aktivitas penting tercatat
- Login/logout tracking
- CRUD operations tracking
- Validation tracking

---

## 📚 Dokumentasi

### Dokumentasi User
- **Admin**: Lihat `DOKUMENTASI_ADMIN.md`
- **Manager**: `DOKUMENTASI_MANAGER.md` (akan dibuat)
- **Staff**: `DOKUMENTASI_STAFF.md` (akan dibuat)

### API Documentation
- Belum tersedia (untuk versi future)

---

## 🧪 Testing

Jalankan test:
```bash
php artisan test
```

---

## 🚧 Development

### Mode Development
```bash
npm run dev
php artisan serve
```

### Build Production
```bash
npm run build
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🐛 Troubleshooting

### Error: Connection Refused
- Pastikan MySQL sudah running
- Cek kredensial database di `.env`

### Error: Permission Denied
```bash
chmod -R 775 storage bootstrap/cache
```

### Assets Tidak Muncul
```bash
npm run build
php artisan optimize
```

### Session Error
```bash
php artisan session:table
php artisan migrate
```

---

## 📈 Roadmap

### Version 1.0 (Current)
- ✅ Authentication & Authorization
- ✅ Admin: User Management
- ✅ Admin: Report Validation
- ✅ Admin: Activity Monitoring
- ✅ Dashboard Admin

### Version 1.1 (Planned)
- ⏳ Manager: Finance Management
- ⏳ Manager: Transaction Report
- ⏳ Manager: Staff Performance
- ⏳ Manager: Forecasting

### Version 1.2 (Planned)
- ⏳ Staff: Transaction Input
- ⏳ Staff: Personal Report
- ⏳ Export to PDF/Excel
- ⏳ Email Notifications

### Version 2.0 (Future)
- ⏳ RESTful API
- ⏳ Mobile App Integration
- ⏳ Advanced Analytics
- ⏳ Real-time Dashboard

---

## 👥 Kontributor

- **Developer**: Tim Sistem Analitik Keuangan
- **Project Manager**: -
- **UI/UX Designer**: -

---

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail.

---

## 📞 Support

Untuk bantuan dan pertanyaan:
- **Email**: support@analitik.com
- **Issue Tracker**: GitHub Issues

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- MySQL
- Community Contributors

---

**Last Updated**: Desember 2025  
**Version**: 1.0.0
