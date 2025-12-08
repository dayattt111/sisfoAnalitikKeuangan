<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\FinancialReport;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $totalStaff = User::where('role', 'staff')->count();
        
        $totalReports = FinancialReport::count();
        $pendingReports = FinancialReport::where('status', 'pending')->count();
        $approvedReports = FinancialReport::where('status', 'approved')->count();
        
        $totalTransactions = Transaction::count();
        $totalPemasukan = Transaction::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaction::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        
        $profitMargin = $totalPemasukan > 0 
            ? round(($saldoAkhir / $totalPemasukan) * 100, 2) 
            : 0;

        $bulanIni = Transaction::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('
                SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as pemasukan,
                SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as pengeluaran
            ')
            ->first();

        $transaksiTerbaru = Transaction::with('user')
            ->latest('tanggal')
            ->take(10)
            ->get();

        $staffPerformance = User::where('role', 'staff')
            ->withCount(['transactions as total_transaksi'])
            ->withSum(['transactions as total_pemasukan' => function($query) {
                $query->where('jenis', 'pemasukan');
            }], 'jumlah')
            ->get();

        $chartData = Transaction::selectRaw('DATE(tanggal) as tanggal, jenis, SUM(jumlah) as total')
            ->whereBetween('tanggal', [now()->subDays(30), now()])
            ->groupBy('tanggal', 'jenis')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('tanggal');

        return view('manager.index', compact(
            'totalStaff',
            'totalReports',
            'pendingReports', 
            'approvedReports',
            'totalTransactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'profitMargin',
            'bulanIni',
            'transaksiTerbaru',
            'staffPerformance',
            'chartData'
        ));
    }
}
