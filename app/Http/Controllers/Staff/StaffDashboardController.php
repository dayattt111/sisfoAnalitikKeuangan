<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\FinancialReport;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total transaksi pribadi
        $totalTransaksi = Transaction::where('user_id', $user->id)->count();
        $totalPemasukan = Transaction::where('user_id', $user->id)
            ->where('jenis', 'pemasukan')
            ->sum('jumlah');
        $totalPengeluaran = Transaction::where('user_id', $user->id)
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah');

        // Statistik laporan keuangan
        $totalLaporan = FinancialReport::where('user_id', $user->id)->count();
        $laporanPending = FinancialReport::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $laporanApproved = FinancialReport::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();
        $laporanRejected = FinancialReport::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->count();

        // Transaksi bulan ini
        $transaksiThisMonth = Transaction::where('user_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $pemasukanThisMonth = Transaction::where('user_id', $user->id)
            ->where('jenis', 'pemasukan')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');

        $pengeluaranThisMonth = Transaction::where('user_id', $user->id)
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');

        // Transaksi terbaru
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Laporan terbaru
        $recentReports = FinancialReport::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Chart data 7 hari terakhir
        $chartData = Transaction::where('user_id', $user->id)
            ->where('tanggal', '>=', now()->subDays(7))
            ->selectRaw('DATE(tanggal) as date, jenis, SUM(jumlah) as total')
            ->groupBy('date', 'jenis')
            ->orderBy('date')
            ->get();

        return view('staff.dashboard', compact(
            'totalTransaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'totalLaporan',
            'laporanPending',
            'laporanApproved',
            'laporanRejected',
            'transaksiThisMonth',
            'pemasukanThisMonth',
            'pengeluaranThisMonth',
            'recentTransactions',
            'recentReports',
            'chartData'
        ));
    }
}
