# Dokumentasi Penggunaan Sistem - Role Admin

## Sistem Informasi Analitik Keuangan Bisnis

---

## 📋 Daftar Isi
1. [Login dan Akses Admin](#1-login-dan-akses-admin)
2. [Dashboard Admin](#2-dashboard-admin)
3. [Kelola Pengguna](#3-kelola-pengguna)
4. [Validasi Laporan Keuangan](#4-validasi-laporan-keuangan)
5. [Monitoring Aktivitas](#5-monitoring-aktivitas)
6. [Kelola Profile](#6-kelola-profile)
7. [Logout](#7-logout)

---

## 1. Login dan Akses Admin

### Kredensial Default
- **Email**: admin@analitik.com
- **Password**: admin123

### Cara Login
1. Buka aplikasi di browser
2. Masukkan email dan password admin
3. Klik tombol "Login"
4. Sistem akan mengarahkan ke Dashboard Admin

### Keamanan
- Password dapat diubah melalui menu Edit Profile
- Email harus terverifikasi
- Setiap aktivitas login akan tercatat dalam system log

---

## 2. Dashboard Admin

Dashboard adalah halaman utama setelah login yang menampilkan:

### Statistik Pengguna
- **Total User**: Jumlah seluruh pengguna terdaftar
- **Total Admin**: Jumlah administrator
- **Total Manager**: Jumlah manager
- **Total Staff**: Jumlah staff

### Statistik Laporan Keuangan
- **Laporan Pending**: Laporan menunggu validasi (warna kuning)
- **Laporan Disetujui**: Laporan yang sudah disetujui (warna hijau)
- **Laporan Ditolak**: Laporan yang ditolak (warna merah)

### Statistik Transaksi
- **Total Transaksi**: Jumlah semua transaksi
- **Total Pemasukan**: Total nominal pemasukan
- **Total Pengeluaran**: Total nominal pengeluaran

### Aktivitas Terbaru
- Menampilkan 10 aktivitas terakhir di sistem
- Menampilkan user yang melakukan aktivitas
- Menampilkan waktu aktivitas (berapa lama yang lalu)

---

## 3. Kelola Pengguna

### Mengakses Menu Kelola User
- Klik menu **"👥 Kelola User"** di sidebar

### Melihat Daftar User
- Tabel menampilkan semua pengguna kecuali admin
- Informasi: No, Nama, Email, Role, Tanggal Terdaftar
- Role dibedakan dengan badge warna:
  - Admin: Merah
  - Manager: Hijau
  - Staff: Biru

### Menambah User Baru
1. Klik tombol **"➕ Tambah User"**
2. Isi form:
   - Nama Lengkap
   - Email (harus unique)
   - Password (minimal 6 karakter)
   - Konfirmasi Password
   - Role (Admin/Manager/Staff)
3. Klik **"💾 Simpan"**
4. User baru akan muncul di daftar

### Mengedit Data User
1. Klik tombol **"Edit"** pada user yang ingin diubah
2. Ubah data yang diperlukan:
   - Nama
   - Email
   - Role
3. **Catatan**: Password tidak bisa diubah dari sini
4. Klik **"💾 Update"**

### Menghapus User
1. Klik tombol **"Hapus"** pada user yang ingin dihapus
2. Konfirmasi penghapusan
3. User akan dihapus dari sistem
4. **Peringatan**: Data yang terkait akan menjadi NULL

### Aktivitas yang Tercatat
- Setiap penambahan user dicatat
- Setiap perubahan data user dicatat
- Setiap penghapusan user dicatat

---

## 4. Validasi Laporan Keuangan

### Mengakses Menu Validasi Laporan
- Klik menu **"📋 Validasi Laporan"** di sidebar

### Melihat Laporan Pending
- Bagian atas menampilkan laporan yang menunggu validasi
- Informasi: ID, Staff Pembuat, Tanggal Dibuat, Status
- Status "Pending" ditandai dengan warna kuning

### Melihat Detail Laporan
1. Klik tombol **"Lihat Detail"** pada laporan
2. Halaman detail menampilkan:
   - Informasi Laporan (ID, Pembuat, Tanggal, Status)
   - Daftar Transaksi dalam laporan
   - Total Pemasukan dan Pengeluaran
   - Tombol aksi validasi

### Menyetujui Laporan
1. Buka detail laporan yang ingin disetujui
2. Review semua transaksi
3. Klik tombol **"✅ Setujui Laporan"**
4. Konfirmasi persetujuan
5. Status laporan berubah menjadi "Approved"
6. Aktivitas dicatat dalam system log

### Menolak Laporan
1. Buka detail laporan yang ingin ditolak
2. Klik tombol **"❌ Tolak Laporan"**
3. Modal akan muncul
4. Isi alasan penolakan (opsional)
5. Klik **"Tolak"**
6. Status laporan berubah menjadi "Rejected"
7. Aktivitas dengan alasan dicatat dalam system log

### Riwayat Validasi
- Bagian bawah menampilkan 20 laporan terakhir yang sudah divalidasi
- Informasi: ID, Staff, Validator, Waktu Validasi, Status
- Status ditandai dengan warna:
  - Approved: Hijau
  - Rejected: Merah

### Tips Validasi
- Pastikan semua transaksi sesuai dengan bukti
- Periksa nominal dan tanggal transaksi
- Berikan alasan jelas saat menolak laporan
- Laporan yang ditolak bisa diperbaiki oleh staff

---

## 5. Monitoring Aktivitas

### Mengakses Menu Monitoring
- Klik menu **"📜 Monitoring Aktivitas"** di sidebar

### Melihat Log Aktivitas
Tabel menampilkan:
- **No**: Nomor urut
- **Waktu**: Tanggal dan jam aktivitas
- **User**: Nama pengguna yang melakukan aktivitas
- **Role**: Role pengguna (Admin/Manager/Staff)
- **Aktivitas**: Deskripsi aktivitas yang dilakukan

### Filter Aktivitas

#### Filter berdasarkan User
- Dropdown "User" menampilkan semua user
- Pilih user untuk melihat aktivitas user tertentu
- Pilih "Semua User" untuk melihat semua

#### Filter berdasarkan Tanggal
- **Dari Tanggal**: Tanggal awal periode
- **Sampai Tanggal**: Tanggal akhir periode
- Kosongkan untuk tidak membatasi tanggal

#### Filter berdasarkan Kata Kunci
- Masukkan kata kunci pada field "Cari Aktivitas"
- Sistem akan mencari di deskripsi aktivitas

#### Menerapkan Filter
1. Atur filter yang diinginkan
2. Klik tombol **"🔍 Filter"**
3. Hasil akan ditampilkan sesuai filter

#### Reset Filter
- Klik tombol **"🔄 Reset"** untuk menghapus semua filter

### Pagination
- Setiap halaman menampilkan 50 log aktivitas
- Gunakan navigasi di bawah tabel untuk berpindah halaman

### Jenis Aktivitas yang Tercatat
- Login dan logout user
- Penambahan, perubahan, dan penghapusan user
- Validasi laporan (approve/reject)
- Semua aktivitas penting dalam sistem

### Tips Monitoring
- Gunakan filter tanggal untuk audit periode tertentu
- Filter user untuk tracking aktivitas user tertentu
- Gunakan kata kunci untuk mencari aktivitas spesifik
- Export data jika diperlukan untuk laporan

---

## 6. Kelola Profile

### Mengakses Edit Profile
- Klik menu **"⚙️ Edit Profil"** di sidebar (bagian bawah)

### Mengubah Informasi Profile
Dapat mengubah:
- **Nama**: Nama lengkap admin
- **Email**: Email untuk login

### Mengubah Password
1. Masukkan password lama
2. Masukkan password baru (minimal 6 karakter)
3. Konfirmasi password baru
4. Klik **"Simpan"**

### Keamanan
- Password di-hash dengan algoritma bcrypt
- Email harus unique dalam sistem
- Perubahan profile akan dicatat dalam log

---

## 7. Logout

### Cara Logout
1. Klik menu **"🚪 Logout"** di sidebar (bagian bawah)
2. Sistem akan:
   - Mencatat aktivitas logout
   - Menghapus session
   - Mengarahkan ke halaman login

### Keamanan
- Selalu logout setelah selesai menggunakan sistem
- Jangan tinggalkan komputer dalam keadaan login
- Gunakan password yang kuat

---

## 📌 Catatan Penting

### Tanggung Jawab Admin
- Admin memiliki akses penuh ke sistem
- Berhati-hati saat menghapus data user
- Validasi laporan dengan teliti
- Monitoring aktivitas secara berkala

### Keamanan Sistem
- Jangan share kredensial login
- Ubah password default setelah login pertama
- Logout setelah selesai
- Laporkan aktivitas mencurigakan

### Pemeliharaan Data
- Backup database secara berkala
- Monitor log aktivitas
- Review user yang tidak aktif
- Arsip laporan lama jika diperlukan

---

## 🆘 Troubleshooting

### Tidak Bisa Login
- Pastikan email dan password benar
- Cek koneksi internet
- Clear cache browser
- Hubungi developer jika masalah berlanjut

### Dashboard Tidak Menampilkan Data
- Refresh halaman
- Cek koneksi database
- Periksa log error

### Error Saat Validasi Laporan
- Pastikan laporan masih berstatus pending
- Refresh halaman dan coba lagi
- Cek log aktivitas untuk detail error

---

## 📞 Kontak Support

Jika mengalami masalah teknis:
- Email: support@analitik.com
- Dokumentasikan error message
- Screenshot jika memungkinkan

---

**Versi**: 1.0  
**Terakhir Diperbarui**: Desember 2025  
**Developer**: Tim Sistem Analitik Keuangan
