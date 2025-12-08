<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FinancialReport;
use App\Models\ActivityLog;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalManager = User::where('role', 'manager')->count();
        $totalStaff = User::where('role', 'staff')->count();

        $pendingReports = FinancialReport::where('status', 'pending')->count();
        $approvedReports = FinancialReport::where('status', 'approved')->count();
        $rejectedReports = FinancialReport::where('status', 'rejected')->count();

        $totalTransactions = Transaction::count();
        $totalPemasukan = Transaction::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaction::where('jenis', 'pengeluaran')->sum('jumlah');

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.index', compact(
            'totalUsers', 'totalAdmin', 'totalManager', 'totalStaff',
            'pendingReports', 'approvedReports', 'rejectedReports',
            'totalTransactions', 'totalPemasukan', 'totalPengeluaran',
            'recentActivities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
