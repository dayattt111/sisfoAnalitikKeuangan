<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    public function index()
    {
        // Data dummy transaksi (bisa diganti dengan model Transaction::all())
        $transactions = [
            ['id' => 1, 'nama_staff' => 'Andi', 'tanggal' => '2025-01-05', 'jenis' => 'Pemasukan', 'jumlah' => 2500000, 'keterangan' => 'Penjualan Produk A'],
            ['id' => 2, 'nama_staff' => 'Budi', 'tanggal' => '2025-01-07', 'jenis' => 'Pengeluaran', 'jumlah' => 1500000, 'keterangan' => 'Pembelian Bahan'],
            ['id' => 3, 'nama_staff' => 'Citra', 'tanggal' => '2025-02-01', 'jenis' => 'Pemasukan', 'jumlah' => 3200000, 'keterangan' => 'Layanan Servis'],
            ['id' => 4, 'nama_staff' => 'Dina', 'tanggal' => '2025-02-10', 'jenis' => 'Pengeluaran', 'jumlah' => 500000, 'keterangan' => 'Transportasi'],
        ];

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = collect($transactions)->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = collect($transactions)->where('jenis', 'Pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('manager.transaction.index', compact('transactions', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'));
    }
}
