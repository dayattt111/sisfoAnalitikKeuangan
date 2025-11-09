<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Manager\FinanceController;
use App\Http\Controllers\Staff\StaffDashboardController;

Route::get('/', function () {
    return view('welcome');
});
  
Route::middleware(['auth'])->group(function () {

    // === Admin Dashboard ===

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
    });

    // === Manager Dashboard ===
Route::middleware(['role:manager'])->prefix('manager')->as('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

    // fitur
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
    Route::get('/transaction', [FinanceController::class, 'index'])->name('transaction');
    Route::get('/report', [FinanceController::class, 'index'])->name('report');
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
