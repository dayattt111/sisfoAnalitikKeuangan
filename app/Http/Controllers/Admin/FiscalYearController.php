<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FiscalYear;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FiscalYearController extends Controller
{
    public function index()
    {
        $fiscalYears = FiscalYear::with('creator')
            ->orderBy('year', 'desc')
            ->paginate(10);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin melihat daftar tahun laporan',
        ]);

        return view('admin.fiscal-years.index', compact('fiscalYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2100|unique:fiscal_years,year',
            'description' => 'nullable|string|max:500',
        ], [
            'year.required' => 'Tahun wajib diisi',
            'year.integer' => 'Tahun harus berupa angka',
            'year.min' => 'Tahun minimal 2020',
            'year.max' => 'Tahun maksimal 2100',
            'year.unique' => 'Tahun ini sudah ditambahkan',
        ]);

        FiscalYear::create([
            'year' => $request->year,
            'is_active' => true,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin menambahkan tahun laporan: ' . $request->year,
        ]);

        return redirect()->route('admin.fiscal-years.index')
            ->with('success', 'Tahun laporan ' . $request->year . ' berhasil ditambahkan');
    }

    public function toggleStatus($id)
    {
        $fiscalYear = FiscalYear::findOrFail($id);
        $fiscalYear->is_active = !$fiscalYear->is_active;
        $fiscalYear->save();

        $status = $fiscalYear->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin ' . $status . ' tahun laporan: ' . $fiscalYear->year,
        ]);

        return redirect()->route('admin.fiscal-years.index')
            ->with('success', 'Tahun laporan ' . $fiscalYear->year . ' berhasil ' . $status);
    }

    public function destroy($id)
    {
        $fiscalYear = FiscalYear::findOrFail($id);
        $year = $fiscalYear->year;
        
        // Check if there are reports for this year
        $reportCount = \App\Models\FinancialReport::where('tahun', $year)->count();
        
        if ($reportCount > 0) {
            return redirect()->route('admin.fiscal-years.index')
                ->with('error', 'Tidak dapat menghapus tahun ' . $year . ' karena masih ada ' . $reportCount . ' laporan');
        }

        $fiscalYear->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin menghapus tahun laporan: ' . $year,
        ]);

        return redirect()->route('admin.fiscal-years.index')
            ->with('success', 'Tahun laporan ' . $year . ' berhasil dihapus');
    }
}
