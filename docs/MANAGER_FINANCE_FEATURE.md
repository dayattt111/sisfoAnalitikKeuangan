# Fitur Manager - Ringkasan Keuangan

## ✅ Fitur yang Sudah Dibuat

### 1. **FinanceController**
File: `app/Http/Controllers/Manager/FinanceController.php`

**Fitur:**
- ✅ Ringkasan keuangan bulanan (Januari - Desember)
- ✅ Filter berdasarkan tahun
- ✅ Total pemasukan, pengeluaran, saldo akhir tahunan
- ✅ Jumlah transaksi per bulan
- ✅ Top 5 staff dengan revenue tertinggi
- ✅ Detail transaksi per bulan
- ✅ Statistik komprehensif

**Method:**
- `index(Request $request)` - Menampilkan ringkasan keuangan bulanan dengan filter tahun
- `show($month)` - Menampilkan detail transaksi untuk bulan tertentu

**Query Features:**
```php
// Aggregasi data bulanan
SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as pemasukan
SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as pengeluaran
COUNT(*) as jumlah_transaksi

// Top staff revenue
SELECT user_id, SUM(jumlah) as total
FROM transactions
WHERE jenis = 'pemasukan' AND YEAR(tanggal) = ?
GROUP BY user_id
ORDER BY total DESC
LIMIT 5
```

---

### 2. **View Files**

#### a. Finance Index
File: `resources/views/manager/finance/index.blade.php`

**Fitur:**
- 📅 Filter tahun (dropdown dengan available years)
- 📊 4 Summary cards:
  - Total Pemasukan (hijau)
  - Total Pengeluaran (merah)
  - Saldo Akhir (biru)
  - Total Transaksi (ungu)
- 📋 Tabel ringkasan 12 bulan dengan:
  - Nama bulan
  - Jumlah transaksi per bulan
  - Pemasukan bulan
  - Pengeluaran bulan
  - Saldo bulan
  - Link detail (jika ada transaksi)
- 🏆 Top 5 Staff Revenue dengan ranking badge

**Design Highlights:**
- Gradient cards dengan icon
- Responsive layout (grid 2:1 untuk tabel & top staff)
- Badge warna untuk ranking:
  - 🥇 #1: Gold (bg-yellow-400)
  - 🥈 #2: Silver (bg-gray-300)
  - 🥉 #3: Bronze (bg-orange-400)
  - #4-5: Blue (bg-blue-100)

#### b. Finance Show
File: `resources/views/manager/finance/show.blade.php`

**Fitur:**
- Breadcrumb navigation (kembali ke ringkasan)
- Summary cards untuk bulan terpilih:
  - Total Pemasukan bulan ini
  - Total Pengeluaran bulan ini
  - Saldo bulan ini
- Tabel detail transaksi dengan:
  - Nomor urut
  - Tanggal
  - Staff (nama + email)
  - Jenis transaksi (badge)
  - Jumlah (color coded)
  - Keterangan (truncated 40 char)
  - Link detail transaksi
- Footer total untuk bulan tersebut

---

### 3. **Routes**
File: `routes/web.php`

```php
Route::middleware(['role:manager'])->prefix('manager')->as('manager.')->group(function () {
    // Finance Routes
    Route::get('/finance', [FinanceController::class, 'index'])
        ->name('finance.index');
    
    Route::get('/finance/{month}', [FinanceController::class, 'show'])
        ->name('finance.show');
});
```

---

### 4. **Layout Navigation**
File: `resources/views/layouts/manager.blade.php`

**Menu Item:**
```blade
<a href="{{ route('manager.finance.index') }}"
   class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:bg-blue-500 hover:pl-5 
          {{ request()->routeIs('manager.finance.*') ? 'bg-blue-600 pl-5 shadow-md' : '' }}">
   <i class="fas fa-chart-line"></i>
   <span>Ringkasan Keuangan</span>
</a>
```

---

## 🧪 Testing

### Login Credentials
```
Email: manager@analitik.com
Password: manager123
```

### URL Testing:
1. **Ringkasan Keuangan**: http://127.0.0.1:8000/manager/finance
2. **Ringkasan Tahun Tertentu**: http://127.0.0.1:8000/manager/finance?year=2025
3. **Detail Bulan**: http://127.0.0.1:8000/manager/finance/1 (Januari)
4. **Detail Bulan dengan Tahun**: http://127.0.0.1:8000/manager/finance/1?year=2025

### Test Scenarios:

#### 1. Test Filter Tahun
```
1. Akses /manager/finance
2. Pilih tahun dari dropdown
3. Klik "Lihat"
4. Verifikasi data berubah sesuai tahun
```

#### 2. Test Detail Bulan
```
1. Dari ringkasan, klik "Detail" pada bulan dengan transaksi
2. Verifikasi menampilkan semua transaksi bulan tersebut
3. Verifikasi summary card sesuai
4. Test breadcrumb "Kembali"
```

#### 3. Test Top Staff
```
1. Verifikasi top 5 staff ditampilkan
2. Verifikasi badge ranking (#1-5)
3. Verifikasi total revenue staff
```

#### 4. Test Empty State
```
1. Pilih bulan tanpa transaksi
2. Verifikasi menampilkan "Tidak ada transaksi"
3. Link detail tidak muncul untuk bulan kosong
```

---

## 📊 Data Flow

```
User Input (Year Filter)
    ↓
FinanceController::index()
    ↓
Query: 
  - Monthly aggregation (12 months)
  - Top 5 staff revenue
  - Available years
    ↓
View: finance/index.blade.php
    ↓
User clicks "Detail" on specific month
    ↓
FinanceController::show($month)
    ↓
Query:
  - All transactions for selected month/year
  - Summary for the month
    ↓
View: finance/show.blade.php
```

---

## 🎨 Design Features

### Color Scheme:
- **Pemasukan**: Green (`from-green-500 to-green-600`)
- **Pengeluaran**: Red (`from-red-500 to-red-600`)
- **Saldo**: Blue (`from-blue-500 to-blue-600`)
- **Total Transaksi**: Purple (`from-purple-500 to-purple-600`)
- **Primary**: Blue/Indigo
- **Neutral**: Gray

### Icons (FontAwesome):
- 📊 `fa-chart-line` - Ringkasan Keuangan
- ⬆️ `fa-arrow-up` - Pemasukan
- ⬇️ `fa-arrow-down` - Pengeluaran
- 💼 `fa-wallet` - Saldo
- 💱 `fa-exchange-alt` - Total Transaksi
- 🏆 `(emoji)` - Top Staff
- 📋 `fa-list` - Daftar Transaksi
- 👁️ `fa-eye` - Detail
- ⬅️ `fa-arrow-left` - Kembali
- 🔍 `fa-search` - Lihat/Filter

### Responsive Design:
- Mobile: 1 kolom
- Tablet: 2 kolom untuk summary cards
- Desktop: 4 kolom untuk summary cards
- Layout finance: 2:1 ratio (tabel : top staff sidebar)

---

## 📈 Statistics Displayed

### Index Page:
1. **Total Pemasukan** - Sum of all income in selected year
2. **Total Pengeluaran** - Sum of all expenses in selected year
3. **Saldo Akhir** - Net balance (income - expense)
4. **Total Transaksi** - Count of all transactions
5. **Monthly Breakdown** - 12 rows with monthly data
6. **Top 5 Staff** - Staff sorted by revenue contribution

### Show Page (Monthly Detail):
1. **Total Pemasukan Bulan** - Monthly income
2. **Total Pengeluaran Bulan** - Monthly expense
3. **Saldo Bulan** - Monthly net balance
4. **Detail Transactions** - All transactions for that month

---

## 🔗 Integration Points

### Links to Other Features:
1. **Finance Index → Finance Show**: Detail bulan
2. **Finance Show → Transaction Show**: Detail transaksi
3. **Navigation Menu → Finance Index**: Menu utama

### Data Dependencies:
- `transactions` table (tanggal, jenis, jumlah, user_id)
- `users` table (name, email, role)
- `financial_reports` table (for transaction relationship)

---

## 💡 Business Logic

### Available Years
Sistem secara otomatis mendeteksi tahun-tahun yang memiliki transaksi:
```php
Transaction::selectRaw('YEAR(tanggal) as year')
    ->distinct()
    ->orderByDesc('year')
    ->pluck('year');
```

### Monthly Loop
Data untuk 12 bulan di-generate meskipun tidak ada transaksi (menampilkan 0):
```php
for ($month = 1; $month <= 12; $month++) {
    // Query transactions for each month
    // Show 0 if no transactions
}
```

### Top Staff Calculation
Hanya menghitung dari transaksi **pemasukan** (bukan pengeluaran):
```php
Transaction::where('jenis', 'pemasukan')
    ->select('user_id', DB::raw('SUM(jumlah) as total'))
    ->groupBy('user_id')
    ->orderByDesc('total')
    ->take(5)
```

---

## 🐛 Troubleshooting

### Data tidak muncul?
```bash
# Cek apakah ada transaksi
php artisan tinker
>>> \App\Models\Transaction::count()

# Cek tahun transaksi
>>> \App\Models\Transaction::selectRaw('YEAR(tanggal) as year')->distinct()->pluck('year')
```

### Filter tahun tidak bekerja?
Pastikan parameter `year` dalam URL:
```
/manager/finance?year=2025
```

### Top Staff kosong?
Pastikan ada transaksi dengan jenis "pemasukan":
```php
Transaction::where('jenis', 'pemasukan')->count()
```

### Detail bulan error 404?
Parameter `month` harus 1-12:
```
/manager/finance/1  ✅
/manager/finance/13 ❌
```

---

## 🎯 Use Cases

### 1. Monthly Financial Review
Manager ingin review performa keuangan per bulan:
1. Akses Finance Index
2. Lihat tabel 12 bulan
3. Identifikasi bulan dengan saldo negatif
4. Klik detail untuk investigasi lebih lanjut

### 2. Year-over-Year Comparison
Manager ingin bandingkan tahun 2024 vs 2025:
1. Filter tahun 2024, catat total
2. Filter tahun 2025, catat total
3. Bandingkan pemasukan/pengeluaran
4. Analisis trend

### 3. Staff Performance Analysis
Manager ingin lihat kontribusi staff:
1. Lihat Top Staff Revenue di sidebar
2. Identifikasi top performer
3. Gunakan data untuk bonus/evaluasi

### 4. Monthly Transaction Audit
Manager ingin audit transaksi bulan tertentu:
1. Klik detail bulan
2. Review semua transaksi
3. Klik detail jika ada yang mencurigakan
4. Lakukan tindakan jika perlu

---

## 📋 Feature Checklist

### Finance Index ✅
- [x] Filter tahun
- [x] 4 Summary cards
- [x] Tabel 12 bulan
- [x] Link detail per bulan
- [x] Top 5 staff revenue
- [x] Ranking badge
- [x] Total row di footer
- [x] Responsive design

### Finance Show ✅
- [x] Breadcrumb navigation
- [x] 3 Summary cards
- [x] Tabel transaksi lengkap
- [x] Link detail transaksi
- [x] Empty state
- [x] Footer total
- [x] Back button

---

## 🔄 Next Steps

Untuk melengkapi fitur manager:
1. ✅ **Finance Controller** - **SELESAI** (ringkasan keuangan bulanan)
2. ✅ **Finance Views** - **SELESAI** (index & show)
3. ✅ **Transaction Controller** - SELESAI (laporan transaksi dengan filter & download)
4. ⏳ **Report Controller** - Pending (laporan komprehensif dengan forecasting)
5. ⏳ **Staff Role** - Pending (fitur untuk role staff)

---

**Status**: ✅ **COMPLETE**
**Last Updated**: 2025-12-08
**Developer**: GitHub Copilot
