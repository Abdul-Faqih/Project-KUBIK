<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // ===============================
    // DASHBOARD
    // ===============================
    Route::get('/dashboard', [DashboardController::class, 'home'])
        ->middleware('web')
        ->name('admin.dashboard.home');

    // Control Assets page
    Route::get('/dashboard/assets', function () {
        return view('admin.dashboard.asset');
    })->name('admin.dashboard.assets');

    // Permissions / Bookings page
    Route::get('/dashboard/bookings', function () {
        return view('admin.dashboard.booking');
    })->name('admin.dashboard.permissions');

    // Export Booking
    Route::get('/export/bookings', [ExportController::class, 'exportBookings'])
        ->name('admin.export.bookings');

    // ===============================
    // AUTH
    // ===============================
    // Login
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');

    // Register
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register.store');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});
