<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialReportValidationController extends Controller
{
    public function index()
    {
        // Laporan yang sudah divalidasi manager, menunggu review admin
        $managerValidated = FinancialReport::whereIn('status', ['approved', 'rejected'])
            ->whereNotNull('komentar_manager')
            ->whereNull('komentar_admin')
            ->with('user')
            ->latest('validated_at')
            ->get();

        // Semua laporan untuk monitoring
        $allReports = FinancialReport::with(['user'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('managerValidated', 'allReports'));
    }

    public function show(FinancialReport $report)
    {
        $report->load(['user', 'transactions']);
        
        $totalPemasukan = $report->transactions()->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $report->transactions()->where('jenis', 'pengeluaran')->sum('jumlah');
        
        return view('admin.reports.show', compact('report', 'totalPemasukan', 'totalPengeluaran'));
    }

    public function addComment(Request $request, FinancialReport $report)
    {
        $request->validate([
            'komentar_admin' => 'required|string|max:1000'
        ]);

        $report->update([
            'komentar_admin' => $request->komentar_admin,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Memberikan komentar pada laporan ID: ' . $report->id . ' dari staff: ' . $report->user->name,
        ]);

        return redirect()->route('admin.reports.show', $report->id)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }
}
