<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FinancialAnalyticsService
{
    /**
     * Calculate financial health metrics for a specific year
     */
    public function calculateHealthMetrics($year)
    {
        $monthlyData = $this->getMonthlyData($year);
        $previousYearData = $this->getMonthlyData($year - 1);

        $currentMetrics = $this->calculateMetrics($monthlyData);
        $previousMetrics = $this->calculateMetrics($previousYearData);

        return [
            'current' => $currentMetrics,
            'previous_year' => $previousMetrics,
            'status' => $this->determineHealthStatus($currentMetrics),
            'recommendations' => $this->generateRecommendations($currentMetrics, $previousMetrics),
        ];
    }

    /**
     * Get monthly transaction summary
     */
    private function getMonthlyData($year)
    {
        $monthlyData = [];
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        for ($month = 1; $month <= 12; $month++) {
            $pemasukan = Transaction::where('jenis', 'pemasukan')
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->sum('jumlah');

            $pengeluaran = Transaction::where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->sum('jumlah');

            $monthlyData[] = [
                'bulan' => $bulanNames[$month],
                'bulan_num' => $month,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran,
            ];
        }

        return $monthlyData;
    }

    /**
     * Calculate financial metrics
     */
    private function calculateMetrics($monthlyData)
    {
        $totalPemasukan = collect($monthlyData)->sum('pemasukan');
        $totalPengeluaran = collect($monthlyData)->sum('pengeluaran');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Avoid division by zero
        $profitMargin = $totalPemasukan > 0 ? ($totalSaldo / $totalPemasukan) * 100 : 0;
        $operatingEfficiency = $totalPemasukan > 0 ? ($totalPengeluaran / $totalPemasukan) * 100 : 0;
        $liquidityRatio = $totalPengeluaran > 0 ? $totalPemasukan / $totalPengeluaran : 0;

        // Calculate growth rate (bulan terakhir vs bulan pertama)
        $lastMonthData = end($monthlyData);
        $firstMonthData = reset($monthlyData);
        $growthRate = $firstMonthData['pemasukan'] > 0 
            ? (($lastMonthData['pemasukan'] - $firstMonthData['pemasukan']) / $firstMonthData['pemasukan']) * 100 
            : 0;

        return [
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'total_saldo' => $totalSaldo,
            'profit_margin' => round($profitMargin, 2),
            'operating_efficiency' => round($operatingEfficiency, 2),
            'liquidity_ratio' => round($liquidityRatio, 2),
            'growth_rate' => round($growthRate, 2),
        ];
    }

    /**
     * Determine health status based on metrics
     */
    private function determineHealthStatus($metrics)
    {
        $healthScores = [];

        // Profit Margin Score (Target > 30%)
        if ($metrics['profit_margin'] >= 30) {
            $healthScores['profit_margin'] = 'Sehat';
        } elseif ($metrics['profit_margin'] >= 15) {
            $healthScores['profit_margin'] = 'Cukup';
        } else {
            $healthScores['profit_margin'] = 'Kurang';
        }

        // Operating Efficiency Score (Target < 70%)
        if ($metrics['operating_efficiency'] <= 70) {
            $healthScores['efficiency'] = 'Baik';
        } elseif ($metrics['operating_efficiency'] <= 85) {
            $healthScores['efficiency'] = 'Cukup';
        } else {
            $healthScores['efficiency'] = 'Buruk';
        }

        // Liquidity Ratio Score (Target > 1.3)
        if ($metrics['liquidity_ratio'] >= 1.3) {
            $healthScores['liquidity'] = 'Likuid';
        } elseif ($metrics['liquidity_ratio'] >= 1.0) {
            $healthScores['liquidity'] = 'Normal';
        } else {
            $healthScores['liquidity'] = 'Defisit';
        }

        // Growth Rate Score
        if ($metrics['growth_rate'] >= 10) {
            $healthScores['growth'] = 'Tumbuh Baik';
        } elseif ($metrics['growth_rate'] >= 0) {
            $healthScores['growth'] = 'Stabil';
        } else {
            $healthScores['growth'] = 'Menurun';
        }

        // Overall Status
        $badCount = array_reduce($healthScores, function($carry, $item) {
            return $carry + (in_array($item, ['Kurang', 'Buruk', 'Menurun', 'Defisit']) ? 1 : 0);
        }, 0);

        if ($badCount >= 2) {
            $overall = 'Kurang';
        } elseif ($badCount >= 1) {
            $overall = 'Cukup';
        } else {
            $overall = 'Sehat';
        }

        return [
            'overall' => $overall,
            'details' => $healthScores,
        ];
    }

    /**
     * Generate recommendations based on metrics
     */
    private function generateRecommendations($currentMetrics, $previousMetrics)
    {
        $recommendations = [];

        // Profit Margin Recommendations
        if ($currentMetrics['profit_margin'] > 30) {
            $recommendations[] = [
                'title' => 'Profit Margin Sangat Sehat',
                'message' => 'Profit margin ' . $currentMetrics['profit_margin'] . '% menunjukkan bisnis Anda sangat menguntungkan.',
                'action' => 'Anda bisa pertimbangkan ekspansi atau investasi untuk growth',
                'type' => 'success',
                'icon' => 'fa-thumbs-up'
            ];
        } elseif ($currentMetrics['profit_margin'] < 15) {
            $recommendations[] = [
                'title' => 'Profit Margin Rendah',
                'message' => 'Profit margin ' . $currentMetrics['profit_margin'] . '% masih di bawah target.',
                'action' => 'Kurangi pengeluaran operasional atau tingkatkan pemasukan',
                'type' => 'danger',
                'icon' => 'fa-exclamation-triangle'
            ];
        }

        // Operating Efficiency Recommendations
        if ($currentMetrics['operating_efficiency'] > 85) {
            $recommendations[] = [
                'title' => 'Efisiensi Operasional Rendah',
                'message' => 'Pengeluaran ' . $currentMetrics['operating_efficiency'] . '% dari pemasukan terlalu tinggi.',
                'action' => 'Review kategori pengeluaran terbesar dan cari area optimasi',
                'type' => 'warning',
                'icon' => 'fa-chart-pie'
            ];
        }

        // Liquidity Recommendations
        if ($currentMetrics['liquidity_ratio'] < 1.0) {
            $recommendations[] = [
                'title' => 'Cash Flow Defisit',
                'message' => 'Pengeluaran lebih besar dari pemasukan (' . number_format($currentMetrics['liquidity_ratio'], 2) . ').',
                'action' => 'Segera evaluasi rencana pengeluaran dan cari sumber pemasukan tambahan',
                'type' => 'danger',
                'icon' => 'fa-exclamation-circle'
            ];
        } elseif ($currentMetrics['liquidity_ratio'] >= 1.5) {
            $recommendations[] = [
                'title' => 'Cash Flow Sehat',
                'message' => 'Pemasukan ' . number_format($currentMetrics['liquidity_ratio'], 2) . 'x lebih besar dari pengeluaran.',
                'action' => 'Posisi likuiditas sangat baik, bisa investasi untuk pertumbuhan',
                'type' => 'success',
                'icon' => 'fa-wallet'
            ];
        }

        // Growth Rate Recommendations
        if ($currentMetrics['growth_rate'] > 10) {
            $recommendations[] = [
                'title' => 'Pertumbuhan Pesat',
                'message' => 'Growth rate ' . $currentMetrics['growth_rate'] . '% menunjukkan pertumbuhan yang sehat.',
                'action' => 'Pertahankan momentum dan fokus pada consistency',
                'type' => 'success',
                'icon' => 'fa-arrow-up'
            ];
        } elseif ($currentMetrics['growth_rate'] < 0) {
            $recommendations[] = [
                'title' => 'Pertumbuhan Negatif',
                'message' => 'Penjualan menurun ' . abs($currentMetrics['growth_rate']) . '% dibanding periode sebelumnya.',
                'action' => 'Lakukan strategi promosi atau review product/service Anda',
                'type' => 'danger',
                'icon' => 'fa-arrow-down'
            ];
        }

        if (empty($recommendations)) {
            $recommendations[] = [
                'title' => 'Kinerja Normal',
                'message' => 'Semua metrik finansial menunjukkan performa yang stabil dan normal.',
                'action' => 'Lanjutkan monitoring dan terus optimalkan operasional',
                'type' => 'info',
                'icon' => 'fa-info-circle'
            ];
        }

        return $recommendations;
    }

    /**
     * Get forecast for next 3 months
     */
    public function getForecast($year)
    {
        $monthlyData = $this->getMonthlyData($year);
        
        // Simple linear regression for forecast
        $pemasukans = collect($monthlyData)->pluck('pemasukan')->toArray();
        $pengeluarans = collect($monthlyData)->pluck('pengeluaran')->toArray();

        $forecastPemasukan = $this->simpleLinearRegression($pemasukans);
        $forecastPengeluaran = $this->simpleLinearRegression($pengeluarans);

        return [
            'pemasukan' => $forecastPemasukan,
            'pengeluaran' => $forecastPengeluaran,
        ];
    }

    /**
     * Simple linear regression forecast
     */
    private function simpleLinearRegression($data)
    {
        $n = count($data);
        $sumX = $sumY = $sumXY = $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumX += $i;
            $sumY += $data[$i];
            $sumXY += $i * $data[$i];
            $sumX2 += $i * $i;
        }

        if ($n * $sumX2 - $sumX * $sumX == 0) {
            return end($data);
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        // Forecast next value
        $nextValue = $intercept + $slope * $n;

        return max(0, round($nextValue));
    }

    /**
     * Get health status color
     */
    public function getStatusColor($status)
    {
        return match($status) {
            'Sehat', 'Baik', 'Likuid', 'Tumbuh Baik' => 'success',
            'Cukup', 'Normal', 'Stabil' => 'warning',
            'Kurang', 'Buruk', 'Menurun', 'Defisit' => 'danger',
            default => 'info',
        };
    }
}
