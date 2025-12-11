<?php

use App\Http\Controllers\UserNotificationController;
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
use App\Http\Controllers\User\Auth\UserAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OnBoardingController;
use App\Http\Controllers\User\UserBookingControlle;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\HistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/test-admin', function () {
    dd(admin());
});


Route::prefix('admin')->group(function () {

    // Landing Page / Root
    Route::get('/', function () {
        // Cek status login menggunakan helper kustom 'user()' Anda
        if (admin()) {
            // Jika SUDAH login (user() mengembalikan objek user/truthy), arahkan ke home.
            return redirect()->route('admin.dashboard.home');
        }

        // Jika BELUM login (user() mengembalikan null/falsy), arahkan ke onboarding 1.
        return redirect()->route('admin.login');
    });

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
    Route::get('/dashboard/asset-masters/{id_master}', [AssetMasterController::class, 'show'])
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
    Route::get('/permissions/filter', [BookingController::class, 'filter'])
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

// ========== AVAILABILITY INFO ==========
Route::get('/availability', [HomeController::class, 'availability'])
    ->name('user.availability');

// CART
Route::post('/cart/add', [HomeController::class, 'addToCart'])
    ->name('user.cart.add');

Route::post('/cart/remove', [HomeController::class, 'removeFromCart'])
    ->name('user.cart.remove');

Route::get('/cart/count', [HomeController::class, 'checkCartState'])
    ->name('user.cart.count');

Route::get('/cart/count/total', [HomeController::class, 'checkTotalCartCount'])
    ->name('user.cart.count.total');

Route::get('/cart/list', [HomeController::class, 'getCartList'])
    ->name('user.cart.list');

// form
Route::get('/form', [UserBookingControlle::class, 'showForm'])
    ->name('user.form');

Route::post('/form/submit', [UserBookingControlle::class, 'submitForm'])
    ->name('user.form.submit');




/* -------------------
     USER PROFILE
------------------- */

Route::get('/profile', [UserProfileController::class, 'index'])
    ->name('user.profile');

Route::get('/profile/notifications', [UserNotificationController::class, 'index'])
    ->name('user.profile.notification');

Route::get('/profile/details', [UserProfileController::class, 'details'])
    ->name('user.profile.details');

Route::get('/profile/settings', [UserProfileController::class, 'settings'])
    ->name('user.profile.settings');

Route::get('/profile/settings/phone', [App\Http\Controllers\User\UserProfileController::class, 'editPhone'])
    ->name('user.settings.phone');

Route::get('/profile/settings/password', [App\Http\Controllers\User\UserProfileController::class, 'editPassword'])
    ->name('user.settings.password');

Route::get('/permissions/history', [HistoryController::class, 'index']) // Methodnya 'index' bukan 'history'
    ->name('user.rentals.history');

// Route Detail
Route::get('/permissions/detail/{id}', [HistoryController::class, 'detail'])
    ->name('user.rentals.detail');

// Route Download
Route::get('/permissions/download/{id}', [HistoryController::class, 'download'])
    ->name('user.rentals.download');
    Route::put('/permissions/{id}/cancel', [UserBookingControlle::class, 'cancelBooking'])
    ->name('user.booking.cancel');

// Route Process Return (Ajukan Pengembalian)
Route::put('/permissions/return/{id}', [HistoryController::class, 'processReturn'])
    ->name('user.rentals.return.process');

