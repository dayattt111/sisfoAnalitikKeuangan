<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Menampilkan daftar laporan yang perlu divalidasi
     */
    public function index()
    {
        // Laporan pending yang perlu divalidasi
        $pendingReports = FinancialReport::where('status', 'pending')
            ->with(['user', 'transactions'])
            ->latest()
            ->get();

        // Laporan yang sudah divalidasi
        $validatedReports = FinancialReport::whereIn('status', ['approved', 'rejected'])
            ->with(['user', 'transactions'])
            ->latest('validated_at')
            ->paginate(20);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Manager melihat daftar validasi laporan',
        ]);

        return view('manager.reports.index', compact('pendingReports', 'validatedReports'));
    }

    /**
     * Menampilkan detail laporan
     */
    public function show(FinancialReport $report)
    {
        $report->load(['user', 'transactions']);
        
        $totalPemasukan = $report->transactions()->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $report->transactions()->where('jenis', 'pengeluaran')->sum('jumlah');
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Manager melihat laporan keuangan ID: ' . $report->id . ' dari staff: ' . $report->user->name,
        ]);
        
        return view('manager.reports.show', compact('report', 'totalPemasukan', 'totalPengeluaran'));
    }

    /**
     * Menyetujui laporan dengan komentar
     */
    public function approve(Request $request, FinancialReport $report)
    {
        $request->validate([
            'komentar_manager' => 'required|string|max:1000'
        ]);

        $report->update([
            'status' => 'approved',
            'komentar_manager' => $request->komentar_manager,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menyetujui laporan keuangan ID: ' . $report->id . ' dari staff: ' . $report->user->name,
        ]);

        return redirect()->route('manager.report.index')
            ->with('success', 'Laporan berhasil disetujui dengan evaluasi!');
    }

    /**
     * Menolak laporan dengan komentar
     */
    public function reject(Request $request, FinancialReport $report)
    {
        $request->validate([
            'komentar_manager' => 'required|string|max:1000'
        ]);

        $report->update([
            'status' => 'rejected',
            'komentar_manager' => $request->komentar_manager,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menolak laporan keuangan ID: ' . $report->id . ' dari staff: ' . $report->user->name,
        ]);

        return redirect()->route('manager.report.index')
            ->with('success', 'Laporan ditolak dengan catatan evaluasi!');
    }

    /**
     * Legacy method - keeping for backwards compatibility
     */
    public function oldIndex()
    {
        // 1. Data Transaksi Dummy
        $transactions = [
            // Pemasukan
            ['type' => 'Pemasukan', 'amount' => 5500000, 'staff_id' => 1, 'date' => '2025-10-01'],
            ['type' => 'Pemasukan', 'amount' => 8200000, 'staff_id' => 2, 'date' => '2025-10-03'],
            ['type' => 'Pemasukan', 'amount' => 1200000, 'staff_id' => 1, 'date' => '2025-10-05'],
            // Pengeluaran (staff_id 99 untuk pengeluaran umum)
            ['type' => 'Pengeluaran', 'amount' => 3000000, 'staff_id' => 99, 'date' => '2025-10-02', 'desc' => 'Sewa Kantor'],
            ['type' => 'Pengeluaran', 'amount' => 800000, 'staff_id' => 99, 'date' => '2025-10-04', 'desc' => 'Biaya Listrik'],
        ];

        // 2. Data Staff Dummy
        $staffs = [
            ['id' => 1, 'name' => 'Andi Pratama', 'role' => 'Penjualan Senior', 'target_revenue' => 15000000],
            ['id' => 2, 'name' => 'Budi Setiawan', 'role' => 'Layanan Pelanggan', 'target_revenue' => 10000000],
            ['id' => 3, 'name' => 'Citra Dewi', 'role' => 'Administrasi', 'target_revenue' => 0],
        ];

        // 3. Hitung Rekapitulasi Keuangan Perusahaan
        $totalPemasukan = collect($transactions)->where('type', 'Pemasukan')->sum('amount');
        $totalPengeluaran = collect($transactions)->where('type', 'Pengeluaran')->sum('amount');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        // Hitung Profit Margin
        $profitMargin = $totalPemasukan > 0 ? round(($saldoAkhir / $totalPemasukan) * 100, 2) : 0;

        // 4. Hitung Rekapitulasi Staff
        $staffRecap = collect($staffs)->map(function ($staff) use ($transactions) {
            $staffTransactions = collect($transactions)->where('staff_id', $staff['id']);
            $pemasukan = $staffTransactions->where('type', 'Pemasukan')->sum('amount');
            // Hitung Progres Target
            $progress = $staff['target_revenue'] > 0 ? round(($pemasukan / $staff['target_revenue']) * 100, 2) : 100;

            return [
                'name' => $staff['name'],
                'role' => $staff['role'],
                'pemasukan' => $pemasukan,
                'target_revenue' => $staff['target_revenue'],
                'progress' => $progress,
            ];
        });
        
        // 5. Data Perkiraan (Forecast) untuk dua bulan ke depan
        $forecast = [
            ['month' => 'November 2025', 'revenue_estimate' => 18000000, 'expense_estimate' => 4500000],
            ['month' => 'Desember 2025', 'revenue_estimate' => 25000000, 'expense_estimate' => 5000000],
        ];

        return view('manager.report.index', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'profitMargin',
            'staffRecap',
            'forecast'
        ));
    }
}