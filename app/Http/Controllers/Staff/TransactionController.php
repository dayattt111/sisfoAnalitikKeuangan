<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\FinancialReport;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('financial_report_id')) {
            $query->where('financial_report_id', $request->financial_report_id);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->paginate(15);

        $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $myReports = FinancialReport::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.transactions.index', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'myReports'
        ));
    }

    public function create()
    {
        $myReports = FinancialReport::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.transactions.create', compact('myReports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'financial_report_id' => 'nullable|exists:financial_reports,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Jika ada financial_report_id, pastikan milik user ini
        if ($request->financial_report_id) {
            $report = FinancialReport::findOrFail($request->financial_report_id);
            if ($report->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'financial_report_id' => $validated['financial_report_id'],
            'tanggal' => $validated['tanggal'],
            'jenis' => $validated['jenis'],
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menambah transaksi ' . $transaction->jenis . ': Rp ' . number_format($transaction->jumlah, 0, ',', '.'),
        ]);

        return redirect()->route('staff.transactions.show', $transaction->id)
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->load('financialReport');

        return view('staff.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $myReports = FinancialReport::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.transactions.edit', compact('transaction', 'myReports'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'financial_report_id' => 'nullable|exists:financial_reports,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Jika ada financial_report_id, pastikan milik user ini
        if ($request->financial_report_id) {
            $report = FinancialReport::findOrFail($request->financial_report_id);
            if ($report->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $transaction->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengupdate transaksi ' . $transaction->jenis . ': Rp ' . number_format($transaction->jumlah, 0, ',', '.'),
        ]);

        return redirect()->route('staff.transactions.show', $transaction->id)
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jenis = $transaction->jenis;
        $jumlah = $transaction->jumlah;
        $transaction->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus transaksi ' . $jenis . ': Rp ' . number_format($jumlah, 0, ',', '.'),
        ]);

        return redirect()->route('staff.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
