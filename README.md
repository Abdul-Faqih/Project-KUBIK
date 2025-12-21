# Project KUBIK — Laravel 12 Asset Management System

![Laravel](https://img.shields.io/badge/Laravel-12.x-ff2d20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-Academic-blue)
![Status](https://img.shields.io/badge/Status-Active-brightgreen)
![GitHub last commit](https://img.shields.io/github/last-commit/Abdul-Faqih/Project-KUBIK?style=flat-square&color=38B2AC)
![GitHub repo size](https://img.shields.io/github/repo-size/Abdul-Faqih/Project-KUBIK?style=flat-square&color=orange)

---

## Tim Pengembang

| Nama | Peran | Kontak |
| :--- | :--- | :--- |
| **Ahmad Abdul Faqih** | Fullstack Developer / Project Owner | [GitHub](https://github.com/Abdul-Faqih), [Instagram](https://www.instagram.com/bdlllll_/) |
| **Muhammad Aghnat Mumtaz** | Fullstack Developer | [GitHub](https://github.com/AghnatMumtaz), [Instagram](https://www.instagram.com/mumoon_z/) |
| Tambahkan Nama Kamu | Frontend / Backend | — |

---

## Panel Kontribusi

Terima kasih kepada seluruh kontributor yang telah membantu mengembangkan **Project KUBIK**.

<a href="https://github.com/Abdul-Faqih/Project-KUBIK/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=Abdul-Faqih/Project-KUBIK" />
</a>

<br><br>

<img src="https://github-readme-activity-graph.vercel.app/graph?username=Abdul-Faqih&bg_color=0D1117&color=5BCDEC&line=5BCDEC&point=FFFFFF&hide_border=true&area=true" width="100%" alt="Activity Graph Abdul" />

<img src="https://github-readme-activity-graph.vercel.app/graph?username=AghnatMumtaz&bg_color=0D1117&color=9F7AEA&line=9F7AEA&point=FFFFFF&hide_border=true&area=true" width="100%" alt="Activity Graph Aghnat" />

---

## Daftar function

### Admin
- [x] login & regist
- [x] dashboard awal
- [x] tampil chart
- [x] tampil asset, cat, type
- [x] search & filter asset
- [x] tampil detail asset, cat, type
- [x] add asset, cat, type
- [x] remove asset, cat, type
- [x] update asset, cat, type
- [x] tampil booking permissions
- [x] tampil detai booking permissions
- [x] setujui permission
- [x] tolak permission
- [X] notifikasi
- [x] logout

### User
- [x] On Boarding
- [x] login & regist
- [x] dashboard awal
- [x] tampil ketersedian asset
- [x] membuat permission
- [x] mengembalikan asset
- [x] tampil status booking
- [x] tampil detail booking
- [x] tampil riwayat booking
- [X] notifikasi
- [x] logout

---

## Deskripsi Singkat

**KUBIK** adalah sistem manajemen aset berbasis web yang dikembangkan menggunakan **Laravel v12** dan **Tailwind CSS**.  
Project ini dibuat untuk kebutuhan akademik (mata kuliah *Pemrograman Web*).  

Fungsionalitas utama:
- Peminjaman & pengembalian aset
- Monitoring stok dan kondisi aset
- Manajemen tipe, kategori, dan aset
- Dashboard interaktif dengan grafik dan statistik real-time

---

### 1. Persiapan Awal

#### Tools yang Dibutuhkan
Pastikan environment berikut sudah ter-install di komputer Anda:

- [PHP 8.2+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/downloads/mysql/)
- [Node.js & NPM](https://nodejs.org/)
- [Git](https://git-scm.com/)
- (Opsional) [VS Code](https://code.visualstudio.com/) dengan ekstensi Laravel

---

### 2. Import Database

Karena proyek ini tidak menggunakan migrasi bawaan, silakan import database secara manual:

1. Buat database baru di MySQL/MariaDB (misalnya bernama: `kubik`).
2. Cari file SQL di direktori project: `db_kubik.sql`.
3. **Import** file `db_kubik.sql` tersebut ke dalam database yang baru Anda buat (gunakan phpMyAdmin, TablePlus, atau DBeaver).

---

### 3. Langkah Instalasi

#### 1. Clone Repository
```bash
git clone [https://github.com/Abdul-Faqih/Project-KUBIK.git](https://github.com/Abdul-Faqih/Project-KUBIK.git)
cd Project-KUBIK
```

#### 2. Install Dependency Laravel

```bash
composer install
```

#### 3. Install Dependency Frontend

```bash
npm install
```

#### 4. Copy File `.env` dan Konfigurasi

```bash
cp .env.example .env
```

Atur koneksi database di file `.env`. Pastikan nama database sesuai dengan yang akan Anda buat (contoh: `kubik`):

```env
DB_DATABASE=kubik
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Generate Key

```bash
php artisan key:generate

```

#### 6. Jalankan Tailwind CSS

```bash
npm run dev

```

#### 7. Jalankan Server Laravel

```bash
php artisan serve

```

---

### 4. Akun & Login Awal Admin dan User

#### Admin

Masuk melalui halaman:

```
http://127.0.0.1:8000/admin
```

Jika sudah ada seeder untuk admin, gunakan akun default berikut:

Akun Super Admin

```
Email: joko@pradita.ac.id
Password: 123456789
```

Akun Admin

```
Email: heru@pradita.ac.id
Password: 123456789
```

#### User

Masuk melalui halaman:

```
http://127.0.0.1:8000
```

Jika sudah ada seeder untuk user, gunakan akun default berikut:

Akun Dosen

```
Email: wahyu@pradita.ac.id
Password: 123456789
```

Akun Mahasiswa

```
Email: siti.aisyah@student.pradita.ac.id
Password: 123456789
```

---

### 5. Route List

Berikut adalah daftar route yang tersedia dalam aplikasi:

```text
  GET|HEAD  / ..................................................................................................................................................................................... 
  GET|HEAD  admin .................................................................................................................................................................................   
  POST      admin/activity/revert/{id} .................................................................................................... admin.activity.revert › Admin\ActivityController@revert   
  GET|HEAD  admin/admin-management ....................................................................................... admin.dashboard.admin_management › Admin\AdminManagementController@index   
  GET|HEAD  admin/admin-management/add ........................................................................ admin.dashboard.admin_management.create › Admin\Auth\AdminAuthController@showCreate   
  POST      admin/admin-management/store ............................................................................ admin.dashboard.admin_management.store › Admin\Auth\AdminAuthController@store   
  GET|HEAD  admin/admin-management/{id} .......................................................................... admin.dashboard.admin_management.detail › Admin\AdminManagementController@detail   
  GET|HEAD  admin/admin-management/{id}/filter ........................................................ admin.dashboard.admin_management.filter › Admin\AdminManagementController@filterPermissions   
  GET|HEAD  admin/admin/permissions/filter .............................................................................................. admin.permissions.filter › Admin\BookingController@filter   
  GET|HEAD  admin/asset-masters/{id_master} .......................................................................................... admin.assetmasters.detail › Admin\AssetMasterController@show
  GET|HEAD  admin/assets/{id_asset} .............................................................................................................. admin.assets.detail › Admin\AssetController@show   
  GET|HEAD  admin/categories .......................................................................................................... admin.dashboard.categories › Admin\CategoryController@index   
  GET|HEAD  admin/categories/{id} ............................................................................................... admin.dashboard.categories.detail › Admin\CategoryController@show   
  DELETE    admin/categories/{id}/delete ..................................................................................... admin.dashboard.categories.delete › Admin\CategoryController@destroy   
  POST      admin/categories/{id}/update ...................................................................................... admin.dashboard.categories.update › Admin\CategoryController@update   
  GET|HEAD  admin/check-notifications ............................................................................ admin.notifications.check › Admin\AdminNotificationController@checkNotifications   
  GET|HEAD  admin/dashboard ................................................................................................................. admin.dashboard.home › Admin\DashboardController@home
  GET|HEAD  admin/dashboard/asset-masters/{id_master} ................................................................................ admin.assetmasters.detail › Admin\AssetMasterController@show   
  DELETE    admin/dashboard/asset-masters/{id}/delete ................................................................... admin.dashboard.assetmasters.delete › Admin\AssetMasterController@destroy   
  POST      admin/dashboard/asset-masters/{id}/update .................................................................... admin.dashboard.assetmasters.update › Admin\AssetMasterController@update   
  GET|HEAD  admin/dashboard/assets ...................................................................................................... admin.dashboard.assets › Admin\DashboardController@assets   
  GET|HEAD  admin/dashboard/assets/add ................................................................................................... admin.assets.create › Admin\AssetMasterController@create   
  GET|HEAD  admin/dashboard/assets/filter ............................................................................................ admin.assets.filter › Admin\DashboardController@filterAssets   
  POST      admin/dashboard/assets/store ................................................................................................... admin.assets.store › Admin\AssetMasterController@store   
  DELETE    admin/dashboard/assets/{id}/delete ...................................................................................... admin.dashboard.assets.delete › Admin\AssetController@destroy   
  POST      admin/dashboard/assets/{id}/update ....................................................................................... admin.dashboard.assets.update › Admin\AssetController@update
  GET|HEAD  admin/dashboard/categories/add .............................................................................................. admin.categories.create › Admin\CategoryController@create   
  POST      admin/dashboard/categories/store .............................................................................................. admin.categories.store › Admin\CategoryController@store   
  GET|HEAD  admin/dashboard/types/add ............................................................................................................ admin.types.create › Admin\TypeController@create   
  POST      admin/dashboard/types/store ............................................................................................................ admin.types.store › Admin\TypeController@store   
  GET|HEAD  admin/export/bookings ................................................................................................... admin.export.bookings › Admin\ExportController@exportBookings   
  GET|HEAD  admin/login .................................................................................................................... admin.login › Admin\Auth\AdminAuthController@showLogin   
  POST      admin/login ................................................................................................................. admin.login.submit › Admin\Auth\AdminAuthController@login   
  GET|HEAD  admin/logout ..................................................................................................................... admin.logout › Admin\Auth\AdminAuthController@logout   
  GET|HEAD  admin/permissions ......................................................................................................... admin.dashboard.permissions › Admin\BookingController@index
  GET|HEAD  admin/permissions/filter .................................................................................................... admin.permissions.filter › Admin\BookingController@filter   
  DELETE    admin/permissions/{id_booking}/remove/{id_asset} .................................................................. admin.permissions.remove_item › Admin\BookingController@removeAsset   
  GET|HEAD  admin/permissions/{id} ........................................................................................................ admin.permissions.detail › Admin\BookingController@show   
  POST      admin/permissions/{id}/accept ............................................................................................... admin.permissions.accept › Admin\BookingController@accept   
  POST      admin/permissions/{id}/reject ............................................................................................... admin.permissions.reject › Admin\BookingController@reject   
  POST      admin/permissions/{id}/update ............................................................................................... admin.permissions.update › Admin\BookingController@update   
  GET|HEAD  admin/profile/{id} ........................................................................................................... admin.dashboard.profile › Admin\ProfileController@detail   
  GET|HEAD  admin/profile/{id}/filter .................................................................................. admin.dashboard.profile.filter › Admin\ProfileController@filterPermissions   
  GET|HEAD  admin/types ........................................................................................................................ admin.dashboard.types › Admin\TypeController@index
  GET|HEAD  admin/types/{id} ............................................................................................................. admin.dashboard.types.detail › Admin\TypeController@show   
  DELETE    admin/types/{id}/delete ................................................................................................... admin.dashboard.types.delete › Admin\TypeController@destroy   
  POST      admin/types/{id}/update .................................................................................................... admin.dashboard.types.update › Admin\TypeController@update   
  GET|HEAD  admin/user-management .......................................................................................... admin.dashboard.user_management › Admin\UserManagementController@index   
  GET|HEAD  admin/user-management/filter ........................................................................... admin.dashboard.user_management.filter › Admin\UserManagementController@filter   
  GET|HEAD  admin/user-management/{id} ............................................................................. admin.dashboard.user_management.detail › Admin\UserManagementController@detail   
  GET|HEAD  availability ..................................................................................................................... user.availability › User\HomeController@availability   
  POST      cart/add ................................................................................................................................ user.cart.add › User\HomeController@addToCart   
  GET|HEAD  cart/count ....................................................................................................................... user.cart.count › User\HomeController@checkCartState
  GET|HEAD  cart/count/total ...................................................................................................... user.cart.count.total › User\HomeController@checkTotalCartCount   
  GET|HEAD  cart/list ............................................................................................................................ user.cart.list › User\HomeController@getCartList   
  POST      cart/remove ..................................................................................................................... user.cart.remove › User\HomeController@removeFromCart   
  GET|HEAD  form ................................................................................................................................... user.form › User\UserBookingControlle@showForm   
  POST      form/submit ................................................................................................................... user.form.submit › User\UserBookingControlle@submitForm   
  GET|HEAD  home ............................................................................................................................................ user.home › User\HomeController@index   
  GET|HEAD  login ............................................................................................................................. user.login › User\Auth\UserAuthController@showLogin   
  POST      login ............................................................................................................................ user.login.post › User\Auth\UserAuthController@login   
  POST      logout .............................................................................................................................. user.logout › User\Auth\UserAuthController@logout   
  GET|HEAD  onboarding/1 .................................................................................................................... user.onboarding.1 › User\OnBoardingController@screen1   
  GET|HEAD  onboarding/2 .................................................................................................................... user.onboarding.2 › User\OnBoardingController@screen2
  GET|HEAD  onboarding/3 .................................................................................................................... user.onboarding.3 › User\OnBoardingController@screen3   
  GET|HEAD  onboarding/finish ........................................................................................................... user.onboarding.finish › User\OnBoardingController@finish   
  GET|HEAD  permissions/detail/{id} ........................................................................................................... user.rentals.detail › User\HistoryController@detail   
  GET|HEAD  permissions/download/{id} ..................................................................................................... user.rentals.download › User\HistoryController@download   
  GET|HEAD  permissions/history ............................................................................................................... user.rentals.history › User\HistoryController@index   
  PUT       permissions/return/{id} ............................................................................................ user.rentals.return.process › User\HistoryController@processReturn   
  PUT       permissions/{id}/cancel ................................................................................................. user.booking.cancel › User\UserBookingControlle@cancelBooking   
  GET|HEAD  profile ............................................................................................................................... user.profile › User\UserProfileController@index   
  GET|HEAD  profile/details ............................................................................................................. user.profile.details › User\UserProfileController@details
  GET|HEAD  profile/settings .......................................................................................................... user.profile.settings › User\UserProfileController@settings   
  GET|HEAD  profile/settings/password ............................................................................................ user.settings.password › User\UserProfileController@editPassword   
  GET|HEAD  profile/settings/phone ..................................................................................................... user.settings.phone › User\UserProfileController@editPhone   
  GET|POST|HEAD register/form ........................................................................................... user.register.form.open › User\Auth\UserAuthController@createRegisterForm   
  GET|HEAD  register/select-role ..................................................................................................... user.register.role › User\Auth\UserAuthController@selectRole
```

---

## Lisensi

Project ini dikembangkan untuk keperluan akademik.
Silakan gunakan dan modifikasi dengan mencantumkan atribusi ke pengembang asli.
