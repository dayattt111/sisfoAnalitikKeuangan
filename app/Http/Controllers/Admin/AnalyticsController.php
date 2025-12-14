<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FinancialAnalyticsService;
use App\Models\ActivityLog;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(FinancialAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Get Financial Analytics
        $healthMetrics = $this->analyticsService->calculateHealthMetrics($year);
        $forecast = $this->analyticsService->getForecast($year);

        // Get available years
        $availableYears = Transaction::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Year-over-Year Comparison
        $yoyComparison = null;
        if ($availableYears->contains($year - 1)) {
            $previousYearMetrics = $this->analyticsService->calculateHealthMetrics($year - 1);
            $yoyComparison = [
                'profit_margin_change' => $healthMetrics['current']['profit_margin'] - $previousYearMetrics['current']['profit_margin'],
                'efficiency_change' => $healthMetrics['current']['operating_efficiency'] - $previousYearMetrics['current']['operating_efficiency'],
                'liquidity_change' => $healthMetrics['current']['liquidity_ratio'] - $previousYearMetrics['current']['liquidity_ratio'],
                'growth_change' => $healthMetrics['current']['growth_rate'] - $previousYearMetrics['current']['growth_rate'],
            ];
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin melihat analitik kesehatan keuangan tahun ' . $year,
        ]);

        return view('admin.analytics.index', compact(
            'year',
            'healthMetrics',
            'forecast',
            'availableYears',
            'yoyComparison'
        ));
    }

    /**
     * Display detailed comparison across years
     */
    public function comparison(Request $request)
    {
        $startYear = $request->input('start_year', now()->year - 2);
        $endYear = $request->input('end_year', now()->year);

        $comparisons = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $metrics = $this->analyticsService->calculateHealthMetrics($year);
            $comparisons[$year] = $metrics;
        }

        $availableYears = Transaction::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin melihat perbandingan analitik tahun ' . $startYear . ' - ' . $endYear,
        ]);

        return view('admin.analytics.comparison', compact(
            'comparisons',
            'startYear',
            'endYear',
            'availableYears'
        ));
    }

    /**
     * Export analytics report
     */
    public function export(Request $request)
    {
        $year = $request->input('year', now()->year);
        $healthMetrics = $this->analyticsService->calculateHealthMetrics($year);
        $forecast = $this->analyticsService->getForecast($year);

        $fileName = 'financial-health-report-' . $year . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($healthMetrics, $forecast, $year) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['FINANCIAL HEALTH SCORECARD REPORT - ' . $year]);
            fputcsv($file, ['Generated on: ' . now()->format('d/m/Y H:i')]);
            fputcsv($file, []);

            // Overall Status
            fputcsv($file, ['OVERALL HEALTH STATUS']);
            fputcsv($file, ['Status', $healthMetrics['status']['overall']]);
            fputcsv($file, []);

            // Current Year Metrics
            fputcsv($file, ['CURRENT YEAR METRICS']);
            fputcsv($file, ['Metric', 'Value', 'Status']);
            fputcsv($file, ['Profit Margin', $healthMetrics['current']['profit_margin'] . '%', $healthMetrics['status']['details']['profit_margin']]);
            fputcsv($file, ['Operating Efficiency', $healthMetrics['current']['operating_efficiency'] . '%', $healthMetrics['status']['details']['efficiency']]);
            fputcsv($file, ['Liquidity Ratio', $healthMetrics['current']['liquidity_ratio'] . 'x', $healthMetrics['status']['details']['liquidity']]);
            fputcsv($file, ['Growth Rate', $healthMetrics['current']['growth_rate'] . '%', $healthMetrics['status']['details']['growth']]);
            fputcsv($file, []);

            // Financial Summary
            fputcsv($file, ['FINANCIAL SUMMARY']);
            fputcsv($file, ['Total Pemasukan', 'Rp ' . number_format($healthMetrics['current']['total_pemasukan'], 0, ',', '.')]);
            fputcsv($file, ['Total Pengeluaran', 'Rp ' . number_format($healthMetrics['current']['total_pengeluaran'], 0, ',', '.')]);
            fputcsv($file, ['Total Saldo', 'Rp ' . number_format($healthMetrics['current']['total_saldo'], 0, ',', '.')]);
            fputcsv($file, []);

            // Forecast
            fputcsv($file, ['FORECAST NEXT MONTH']);
            fputcsv($file, ['Projected Income', 'Rp ' . number_format($forecast['pemasukan'], 0, ',', '.')]);
            fputcsv($file, ['Projected Expense', 'Rp ' . number_format($forecast['pengeluaran'], 0, ',', '.')]);
            fputcsv($file, []);

            // Recommendations
            fputcsv($file, ['RECOMMENDATIONS']);
            foreach ($healthMetrics['recommendations'] as $rec) {
                fputcsv($file, [$rec['title'], $rec['message'], $rec['action']]);
            }

            fclose($file);
        };

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Admin mengunduh laporan analitik tahun ' . $year,
        ]);

        return response()->stream($callback, 200, $headers);
    }
}
