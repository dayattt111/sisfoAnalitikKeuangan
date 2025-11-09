<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index()
    {
        // Data dummy untuk ringkasan keuangan bulanan
        $monthlyData = [
            ['bulan' => 'Januari', 'pemasukan' => 12000000, 'pengeluaran' => 7000000],
            ['bulan' => 'Februari', 'pemasukan' => 10000000, 'pengeluaran' => 5000000],
            ['bulan' => 'Maret', 'pemasukan' => 15000000, 'pengeluaran' => 8000000],
            ['bulan' => 'April', 'pemasukan' => 11000000, 'pengeluaran' => 6000000],
            ['bulan' => 'Mei', 'pemasukan' => 13000000, 'pengeluaran' => 9000000],
            ['bulan' => 'Juni', 'pemasukan' => 14000000, 'pengeluaran' => 8500000],
        ];

        // Ringkasan tahunan
        $totalPemasukan = collect($monthlyData)->sum('pemasukan');
        $totalPengeluaran = collect($monthlyData)->sum('pengeluaran');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('manager.finance.index', compact(
            'monthlyData', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'
        ));
    }
}
