<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\FinancialReportValidationController;
use App\Http\Controllers\Admin\ActivityLogController;

use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Manager\FinanceController;
use App\Http\Controllers\Manager\TransactionReportController;
use App\Http\Controllers\Manager\ReportController;

use App\Http\Controllers\Staff\StaffDashboardController;

Route::get('/', function () {
    return view('welcome');
});
  
Route::middleware(['auth'])->group(function () {

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
    
    Route::get('/reports', [FinancialReportValidationController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [FinancialReportValidationController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/approve', [FinancialReportValidationController::class, 'approve'])->name('reports.approve');
    Route::post('/reports/{report}/reject', [FinancialReportValidationController::class, 'reject'])->name('reports.reject');
    
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

    // === Manager Dashboard ===
Route::middleware(['role:manager'])->prefix('manager')->as('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

    // fitur
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/{month}', [FinanceController::class, 'show'])->name('finance.show');
    
    Route::get('/transaction', [TransactionReportController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/{transaction}', [TransactionReportController::class, 'show'])->name('transaction.show');
    Route::get('/transaction-download-pdf', [TransactionReportController::class, 'downloadPdf'])->name('transaction.download-pdf');
    Route::get('/transaction-download-csv', [TransactionReportController::class, 'downloadCsv'])->name('transaction.download-csv');
    
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    });

    // Staff Dashb
Route::middleware(['role:staff'])->prefix('staff')->as('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    });
});

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
