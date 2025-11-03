<?php
namespace App\Http\Controllers;

use App\Models\FinancialReport;
use App\Models\Transaction;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(FinancialReport $financialReport): View
    {
        // Menggunakan route model binding: $financialReport sudah instance model
        // Ambil transaksi terkait laporan
        $transactions = $financialReport->transactions;
        // Kirim ke view transactions/index.blade.php
        return view('transactions.index', compact('financialReport', 'transactions'));
    }

    public function show(FinancialReport $financialReport, Transaction $transaction): View
    {
        // Tampilkan detail satu transaksi
        return view('transactions.show', compact('financialReport', 'transaction'));
    }
}
