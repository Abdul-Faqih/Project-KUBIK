<?php

use Illuminate\Support\Facades\Route;

/* ======================
      ADMIN
====================== */

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetMasterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\BookingController;

Route::prefix('admin')->group(function () {

    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('admin.dashboard.home');
    Route::get('/dashboard/assets', [DashboardController::class, 'assets'])->name('admin.dashboard.assets');

    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.dashboard.categories');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('admin.dashboard.categories.detail');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('admin.dashboard.categories.update');
    Route::delete('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('admin.dashboard.categories.delete');

    // Type
    Route::get('/types', [TypeController::class, 'index'])->name('admin.dashboard.types');
    Route::get('/types/{id}', [TypeController::class, 'show'])->name('admin.dashboard.types.detail');
    Route::post('/types/{id}/update', [TypeController::class, 'update'])->name('admin.dashboard.types.update');
    Route::delete('/types/{id}/delete', [TypeController::class, 'destroy'])->name('admin.dashboard.types.delete');

    // Assets
    Route::get('/assets/{id_asset}', [AssetController::class, 'show'])->name('admin.assets.detail');
    Route::post('/dashboard/assets/{id}/update', [AssetController::class, 'update'])->name('admin.dashboard.assets.update');
    Route::delete('/dashboard/assets/{id}/delete', [AssetController::class, 'destroy'])->name('admin.dashboard.assets.delete');

    // Asset Masters
    Route::get('/asset-masters/{id_master}', [AssetMasterController::class, 'show'])->name('admin.assetmasters.detail');
    Route::post('/dashboard/asset-masters/{id}/update', [AssetMasterController::class, 'update'])->name('admin.dashboard.assetmasters.update');
    Route::delete('/dashboard/asset-masters/{id}/delete', [AssetMasterController::class, 'destroy'])->name('admin.dashboard.assetmasters.delete');

    // Bookings
    Route::get('/permissions', [BookingController::class, 'index'])->name('admin.dashboard.permissions');
    Route::get('/admin/permissions/filter', [BookingController::class, 'filter'])->name('admin.permissions.filter');
    Route::get('/permissions/{id}', [BookingController::class, 'show'])->name('admin.permissions.detail');
    Route::post('/permissions/{id}/update', [BookingController::class, 'update'])->name('admin.permissions.update');
    Route::post('/permissions/{id}/accept', [BookingController::class, 'accept'])->name('admin.permissions.accept');
    Route::post('/permissions/{id}/reject', [BookingController::class, 'reject'])->name('admin.permissions.reject');

    // Export
    Route::get('/export/bookings', [ExportController::class, 'exportBookings'])->name('admin.export.bookings');
});


/* ======================
      USER
====================== */

use App\Http\Controllers\User\Auth\UserAuthController;
use App\Http\Controllers\User\OnBoardingController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\HistoryController;

Route::prefix('user')->group(function () {

    /* -------------------
         ONBOARDING
    ------------------- */
    Route::get('/', function () {
        if (!session()->has('user_onboarding')) {
            return redirect()->route('user.onboarding.1');
        }
        return redirect()->route('user.home');
    });

    Route::get('/onboarding/1', [OnBoardingController::class, 'screen1'])->name('user.onboarding.1');
    Route::get('/onboarding/2', [OnBoardingController::class, 'screen2'])->name('user.onboarding.2');
    Route::get('/onboarding/3', [OnBoardingController::class, 'screen3'])->name('user.onboarding.3');
    Route::get('/onboarding/finish', [OnBoardingController::class, 'finish'])->name('user.onboarding.finish');



    /* -------------------
         USER AUTH
    ------------------- */

    // LOGIN
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.post');
    Route::get('/availability', [App\Http\Controllers\User\HomeController::class, 'availability'])
        ->name('user.availability');


    /* -------------------
        REGISTER (FINAL)
    ------------------- */

    // 1. Tampilkan Halaman Pilih Role (UBAH JADI GET)
    Route::get('/register/select-role', [UserAuthController::class, 'selectRole'])
        ->name('user.register.role');

    // 2. Proses Role & Buka Form Register (POST)
    Route::match(['get', 'post'], '/register/form', [UserAuthController::class, 'createRegisterForm'])
        ->name('user.register.form.open');

    // 3. Submit Data Final (POST)
    Route::post('/register/submit', [UserAuthController::class, 'submitRegister'])
        ->name('user.register.submit');




    // LOGOUT
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');



    /* -------------------
         USER HOME
    ------------------- */

    Route::get('/home', [HomeController::class, 'index'])->name('user.home');



    /* -------------------
         USER PROFILE
    ------------------- */

    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/details', [UserProfileController::class, 'details'])->name('user.profile.details');
    Route::get('/profile/settings', [UserProfileController::class, 'settings'])->name('user.profile.settings');
    Route::get('/profile/settings/phone', [App\Http\Controllers\User\UserProfileController::class, 'editPhone'])->name('user.settings.phone');
    Route::get('/profile/settings/password', [App\Http\Controllers\User\UserProfileController::class, 'editPassword'])->name('user.settings.password');
    Route::get('/rentals/history', [HistoryController::class, 'index']) // Methodnya 'index' bukan 'history'
    ->name('user.rentals.history');
    // Route Detail
    Route::get('/rentals/detail/{id}', [HistoryController::class, 'detail'])
        ->name('user.rentals.detail');

    // Route Download
    Route::get('/rentals/download/{id}', [HistoryController::class, 'download'])
        ->name('user.rentals.download');
        
    // Route Upload Pengembalian (Opsional, buat nanti)
    Route::post('/rentals/return/{id}', [HistoryController::class, 'processReturn'])
        ->name('user.rentals.return');

});
