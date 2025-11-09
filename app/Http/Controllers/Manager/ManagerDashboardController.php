<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\FinancialReport;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $totalReports = FinancialReport::count();
        $monthlyTransactions = Transaction::whereMonth('created_at', now()->month)->count();
        $totalStaff = User::where('role', 'staff')->count();

        return view('manager.index', compact('totalReports', 'monthlyTransactions', 'totalStaff'));
    }
}
