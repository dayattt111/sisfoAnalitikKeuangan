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

        return view('staff.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('staff.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $report = FinancialReport::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'periode_mulai' => $validated['periode_mulai'],
            'periode_akhir' => $validated['periode_akhir'],
            'status' => 'pending',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Membuat laporan keuangan: ' . $report->judul,
        ]);

        return redirect()->route('staff.reports.show', $report->id)
            ->with('success', 'Laporan keuangan berhasil dibuat!');
    }

    public function show(FinancialReport $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $report->load('transactions');

        $totalPemasukan = $report->transactions()
            ->where('jenis', 'pemasukan')
            ->sum('jumlah');

        $totalPengeluaran = $report->transactions()
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah');

        return view('staff.reports.show', compact('report', 'totalPemasukan', 'totalPengeluaran'));
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $report->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengupdate laporan keuangan: ' . $report->judul,
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

        $judul = $report->judul;
        $report->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus laporan keuangan: ' . $judul,
        ]);

        return redirect()->route('staff.reports.index')
            ->with('success', 'Laporan keuangan berhasil dihapus!');
    }
}
