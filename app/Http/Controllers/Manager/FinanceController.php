<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index()
    {
        $total_pemasukan = Transaction::where('jenis', 'pemasukan')->sum('jumlah');
        $total_pengeluaran = Transaction::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo_akhir = $total_pemasukan - $total_pengeluaran;

        // Grafik data
        $grafik = Transaction::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) as total_pemasukan'),
            DB::raw('SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as total_pengeluaran')
        )
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        return view('manager.finance.index', compact(
            'total_pemasukan', 'total_pengeluaran', 'saldo_akhir', 'grafik'
        ));
    }
}
