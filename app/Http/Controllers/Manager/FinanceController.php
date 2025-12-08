<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        
        $monthlyData = [];
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        for ($month = 1; $month <= 12; $month++) {
            $data = Transaction::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->selectRaw('
                    SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as pemasukan,
                    SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as pengeluaran,
                    COUNT(*) as jumlah_transaksi
                ')
                ->first();

            $monthlyData[] = [
                'bulan' => $bulanNames[$month],
                'bulan_num' => $month,
                'pemasukan' => $data->pemasukan ?? 0,
                'pengeluaran' => $data->pengeluaran ?? 0,
                'saldo' => ($data->pemasukan ?? 0) - ($data->pengeluaran ?? 0),
                'jumlah_transaksi' => $data->jumlah_transaksi ?? 0,
            ];
        }

        $totalPemasukan = collect($monthlyData)->sum('pemasukan');
        $totalPengeluaran = collect($monthlyData)->sum('pengeluaran');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        $totalTransaksi = collect($monthlyData)->sum('jumlah_transaksi');

        $topStaffRevenue = Transaction::where('jenis', 'pemasukan')
            ->whereYear('tanggal', $year)
            ->select('user_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user')
            ->take(5)
            ->get();

        $availableYears = Transaction::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Manager melihat ringkasan keuangan tahun ' . $year,
        ]);

        return view('manager.finance.index', compact(
            'monthlyData',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'totalTransaksi',
            'topStaffRevenue',
            'year',
            'availableYears'
        ));
    }

    public function show($month)
    {
        $year = request('year', now()->year);
        
        $transactions = Transaction::with('user')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal', 'desc')
            ->get();

        $summary = Transaction::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->selectRaw('
                SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as pemasukan,
                SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as pengeluaran
            ')
            ->first();

        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Manager melihat detail keuangan bulan ' . $bulanNames[$month] . ' ' . $year,
        ]);

        return view('manager.finance.show', compact(
            'transactions',
            'summary',
            'month',
            'year',
            'bulanNames'
        ));
    }
}
