<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialReport;
use App\Models\Transaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    public function index()
    {
        $reports = FinancialReport::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Staff melihat daftar laporan keuangan',
        ]);

        return view('staff.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('staff.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        // Check if report already exists for this month/year
        $existing = FinancialReport::where('user_id', Auth::id())
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withErrors(['bulan' => 'Anda sudah memiliki laporan untuk periode ini.'])
                ->withInput();
        }

        $report = FinancialReport::create([
            'user_id' => Auth::id(),
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'status' => 'pending',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Membuat laporan keuangan: ' . $report->bulan . '/' . $report->tahun,
        ]);

        return redirect()->route('staff.reports.show', $report->id)
            ->with('success', 'Laporan keuangan berhasil dibuat! Silakan tambahkan transaksi.');
    }

    public function show(FinancialReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $report->load('transactions');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Melihat detail laporan keuangan: ' . $report->bulan . '/' . $report->tahun,
        ]);

        return view('staff.reports.show', compact('report'));
    }

    public function edit(FinancialReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($report->status !== 'pending') {
            return redirect()->route('staff.reports.show', $report->id)
                ->with('error', 'Hanya laporan dengan status pending yang dapat diedit!');
        }

        return view('staff.reports.edit', compact('report'));
    }

    public function update(Request $request, FinancialReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($report->status !== 'pending') {
            return redirect()->route('staff.reports.show', $report->id)
                ->with('error', 'Hanya laporan dengan status pending yang dapat diedit!');
        }

        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        // Check if another report exists for this month/year (excluding current)
        $existing = FinancialReport::where('user_id', Auth::id())
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->where('id', '!=', $report->id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withErrors(['bulan' => 'Anda sudah memiliki laporan untuk periode ini.'])
                ->withInput();
        }

        $report->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengupdate laporan keuangan: ' . $report->bulan . '/' . $report->tahun,
        ]);

        return redirect()->route('staff.reports.show', $report->id)
            ->with('success', 'Laporan keuangan berhasil diupdate!');
    }

    public function destroy(FinancialReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($report->status !== 'pending') {
            return redirect()->route('staff.reports.index')
                ->with('error', 'Hanya laporan dengan status pending yang dapat dihapus!');
        }

        $periode = $report->bulan . '/' . $report->tahun;
        $report->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus laporan keuangan: ' . $periode,
        ]);

        return redirect()->route('staff.reports.index')
            ->with('success', 'Laporan keuangan berhasil dihapus!');
    }
}
