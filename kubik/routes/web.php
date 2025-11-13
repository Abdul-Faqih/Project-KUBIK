<?php

use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetMasterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TypeController;
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

    // ASSETS PAGE
    Route::get('/dashboard/assets', [DashboardController::class, 'assets'])
        ->name('admin.dashboard.assets');

    // ASSET DETAIL
    Route::get('/assets/{id_asset}', [AssetController::class, 'show'])->name('admin.assets.detail');

    // ASSET MASTER DETAIL
    Route::get('/asset-masters/{id_master}', [AssetMasterController::class, 'show'])->name('admin.assetmasters.detail');

    // CATEGORY DETAIL
    Route::get('/categories/{id}', [CategoryController::class, 'show'])
        ->name('admin.dashboard.categories.detail');
    //CATEGORY update and delete
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('admin.dashboard.categories.update');
    Route::delete('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('admin.dashboard.categories.delete');

    // TYPE DETAIL
    Route::get('/types/{id}', [TypeController::class, 'show'])
        ->name('admin.dashboard.types.detail');
        
    // Type update (edit name only)
    Route::post('/types/{id}/update', [TypeController::class, 'update'])->name('admin.dashboard.types.update');

    // Type delete
    Route::delete('/types/{id}/delete', [TypeController::class, 'destroy'])->name('admin.dashboard.types.delete');

    // Permissions / Bookings page
    Route::get('/dashboard/bookings', function () {
        return view('admin.dashboard.booking');
    })->name('admin.dashboard.permissions');

    // Export Booking
    Route::get('/export/bookings', [
        ExportController::class,
        'exportBookings'
    ])->name('admin.export.bookings');

    // Route untuk filter dan search aset
    Route::get('/dashboard/assets/filter', [DashboardController::class, 'filterAssets'])->name('admin.assets.filter');

    // Add Type
    Route::get('/dashboard/types/add', [TypeController::class, 'create'])->name('admin.types.create');
    Route::post('/dashboard/types/store', [TypeController::class, 'store'])->name('admin.types.store');

    // Add Category
    Route::get('/dashboard/categories/add', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/dashboard/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');

    // Add Asset
    Route::get('/dashboard/assets/add', [AssetMasterController::class, 'create'])->name('admin.assets.create');
    Route::post('/dashboard/assets/store', [AssetMasterController::class, 'store'])->name('admin.assets.store');

    // ===============================
    // AUTH
    // ===============================
    // Login
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
    
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});
