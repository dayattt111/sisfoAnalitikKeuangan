<?php
namespace App\Http\Controllers;

use App\Models\FinancialReport;
use Illuminate\View\View;

class FinancialReportController extends Controller
{
    public function index(): View
    {
        // Ambil semua laporan keuangan
        $reports = FinancialReport::all();
        // Kirim data ke view financial_reports/index.blade.php
        return view('financial_reports.index', compact('reports')); 
    }

    public function show(int $id): View
    {
        // Cari laporan berdasarkan ID, atau gagal 404 jika tidak ada
        $report = FinancialReport::findOrFail($id);
        // Jika relasi: misalnya $report->transactions() sudah didefinisikan di model
        $transactions = $report->transactions ?? [];
        // Kirim data ke view financial_reports/show.blade.php
        return view('financial_reports.show', compact('report', 'transactions'));
    }
}
