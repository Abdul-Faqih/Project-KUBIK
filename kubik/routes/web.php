<?php

use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetMasterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\User\Auth\UserAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OnBoardingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/test-admin', function () {
    dd(admin());
});


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

    // TYPES PAGE
    Route::get('/types', [TypeController::class, 'index'])
        ->name('admin.dashboard.types');

    // CATEGORIES PAGE
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('admin.dashboard.categories');

    // ASSET DETAIL
    Route::get('/assets/{id_asset}', [AssetController::class, 'show'])->name('admin.assets.detail');

    // Update Asset
    Route::post('/dashboard/assets/{id}/update', [AssetController::class, 'update'])
        ->name('admin.dashboard.assets.update');

    // Delete Asset
    Route::delete('/dashboard/assets/{id}/delete', [AssetController::class, 'destroy'])
        ->name('admin.dashboard.assets.delete');

    // ASSET MASTER DETAIL
    Route::get('/asset-masters/{id_master}', [AssetMasterController::class, 'show'])
        ->name('admin.assetmasters.detail');

    // Update Asset Master
    Route::post('/dashboard/asset-masters/{id}/update', [AssetMasterController::class, 'update'])
        ->name('admin.dashboard.assetmasters.update');

    // Delete Asset Master
    Route::delete('/dashboard/asset-masters/{id}/delete', [AssetMasterController::class, 'destroy'])
        ->name('admin.dashboard.assetmasters.delete');

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

    // Permission / Booking Page
    Route::get('/permissions', [BookingController::class, 'index'])
        ->name('admin.dashboard.permissions');

    // Filter AJAX
    Route::get('/admin/permissions/filter', [BookingController::class, 'filter'])
        ->name('admin.permissions.filter');

    // Permission Detail
    Route::get('/permissions/{id}', [BookingController::class, 'show'])
        ->name('admin.permissions.detail');

    // Update
    Route::post('/permissions/{id}/update', [BookingController::class, 'update'])
        ->name('admin.permissions.update');

    // Accept
    Route::post('/permissions/{id}/accept', [BookingController::class, 'accept'])
        ->name('admin.permissions.accept');

    // Reject
    Route::post('/permissions/{id}/reject', [BookingController::class, 'reject'])
        ->name('admin.permissions.reject');

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
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

/* ======================
      USER 
====================== */

Route::prefix('user')->group(function () {

    // ONBOARDING
    Route::get('/', function () {
        // Cek sesi: Jika belum ada 'user_onboarding', arahkan ke onboarding 1
        if (!session()->has('user_onboarding')) {
            return redirect()->route('user.onboarding.1');
        }

        // Jika sudah ada, arahkan ke dashboard
        return redirect()->route('user.home');
    });

    // Onboarding Screens
    Route::get('/onboarding/1', [OnBoardingController::class, 'screen1'])->name('user.onboarding.1');
    Route::get('/onboarding/2', [OnBoardingController::class, 'screen2'])->name('user.onboarding.2');
    Route::get('/onboarding/3', [OnBoardingController::class, 'screen3'])->name('user.onboarding.3');

    // skip (langsung ke login)
    Route::get('/onboarding/finish', [OnBoardingController::class, 'finish'])->name('user.onboarding.finish');


    /* ======================
      USER AUTH
    ====================== */

    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login']);

    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register']);

    Route::get('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    // USER HOME
    Route::get('/home', [HomeController::class, 'index'])->name('user.home');

    // ========== AVAILABILITY INFO ==========
    Route::get('/availability', [HomeController::class, 'availability'])
        ->name('user.availability');
});



