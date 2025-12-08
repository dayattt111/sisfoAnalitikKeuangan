<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->paginate(20);

        $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $staffList = User::where('role', 'staff')->orderBy('name')->get();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Manager melihat laporan transaksi',
        ]);

        return view('manager.transaction.index', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'staffList'
        ));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user', 'financialReport');
        return view('manager.transaction.show', compact('transaction'));
    }

    public function downloadPdf(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->get();

        $totalPemasukan = $transactions->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transactions->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $pdf = Pdf::loadView('manager.transaction.pdf', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'request'
        ));

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Download laporan transaksi (PDF) - ' . $transactions->count() . ' transaksi',
        ]);

        return $pdf->download('laporan-transaksi-' . now()->format('YmdHis') . '.pdf');
    }

    public function downloadCsv(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->get();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Download laporan transaksi (Excel) - ' . $transactions->count() . ' transaksi',
        ]);

        $filename = 'laporan-transaksi-' . now()->format('YmdHis') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Tanggal', 'Staff', 'Jenis', 'Jumlah', 'Keterangan']);

            foreach ($transactions as $index => $transaction) {
                fputcsv($file, [
                    $index + 1,
                    $transaction->tanggal,
                    $transaction->user->name ?? '-',
                    ucfirst($transaction->jenis),
                    $transaction->jumlah,
                    $transaction->keterangan ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
