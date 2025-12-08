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
        $pendingReports = FinancialReport::where('status', 'pending')
            ->with('staff')
            ->latest()
            ->get();

        $validatedReports = FinancialReport::whereIn('status', ['approved', 'rejected'])
            ->with(['staff', 'validatedBy'])
            ->latest('validated_at')
            ->take(20)
            ->get();

        return view('admin.reports.index', compact('pendingReports', 'validatedReports'));
    }

    public function show(FinancialReport $report)
    {
        $report->load(['staff', 'validatedBy', 'transactions']);
        return view('admin.reports.show', compact('report'));
    }

    public function approve(FinancialReport $report)
    {
        $report->update([
            'status' => 'approved',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menyetujui laporan keuangan ID: ' . $report->id . ' dari staff: ' . $report->staff->name,
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil disetujui!');
    }

    public function reject(Request $request, FinancialReport $report)
    {
        $request->validate([
            'rejection_note' => 'nullable|string|max:500'
        ]);

        $report->update([
            'status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menolak laporan keuangan ID: ' . $report->id . ' dari staff: ' . $report->staff->name . 
                         ($request->rejection_note ? ' - Alasan: ' . $request->rejection_note : ''),
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil ditolak!');
    }
}
