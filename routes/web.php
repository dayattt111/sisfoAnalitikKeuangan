<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/admin/dashboard', function () {
    //     return view('dashboard', ['role' => 'admin']);
    // })->name('admin.dashboard')->middleware('role.admin');
    // Route::get('/manager/dashboard', function () {
    //     return view('dashboard', ['role' => 'manager']);
    // })->name('manager.dashboard')->middleware('role.manager');
    // Route::get('/staff/dashboard', function () {
    //     return view('dashboard', ['role' => 'staff']);
    // })->name('staff.dashboard')->middleware('role.staff');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard', ['role' => 'Admin']);
    })->name('admin.dashboard')->middleware('role:admin');

    Route::get('/manager/dashboard', function () {
        return view('dashboard', ['role' => 'Manager']);
    })->name('manager.dashboard')->middleware('role:manager');

    Route::get('/staff/dashboard', function () {
        return view('dashboard', ['role' => 'Staff']);
    })->name('staff.dashboard')->middleware('role:staff');
});    



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
