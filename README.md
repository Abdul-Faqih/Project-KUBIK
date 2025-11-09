# 🧩 Project KUBIK — Laravel 12 Asset Management System

![Laravel](https://img.shields.io/badge/Laravel-12.x-ff2d20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-Academic-blue)
![Status](https://img.shields.io/badge/Status-Active-brightgreen)

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
- [ ] remove asset, cat, type
- [ ] update asset, cat, type
- [ ] tampil booking permissions
- [ ] tampil detai booking permissions
- [ ] setujui permission
- [ ] tolak permission
- [ ] notifikasi
- [ ] ubah profil
- [ ] logout

### User
- [ ] login & regist
- [ ] dashboard awal
- [ ] tampil ketersedian asset
- [ ] membuat permission
- [ ] mengembalikan asset
- [ ] tampil status booking
- [ ] tampil detail booking
- [ ] tampil riwayat booking
- [ ] notifikasi
- [ ] ubah profil
- [ ] logout
---

## 📘 Deskripsi Singkat

**KUBIK** adalah sistem manajemen aset berbasis web yang dikembangkan menggunakan **Laravel v12** dan **Tailwind CSS**.  
Project ini dibuat untuk kebutuhan akademik (mata kuliah *Pemrograman Web*).  

Fungsionalitas utama:
- Peminjaman & pengembalian aset
- Monitoring stok dan kondisi aset
- Manajemen tipe, kategori, dan aset
- Dashboard interaktif dengan grafik dan statistik real-time

---

## ⚙️ 1. Persiapan Awal

### 🧰 Tools yang Dibutuhkan
Pastikan environment berikut sudah ter-install di komputer Anda:

- [PHP 8.2+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/downloads/mysql/)
- [Node.js & NPM](https://nodejs.org/)
- [Git](https://git-scm.com/)
- (Opsional) [VS Code](https://code.visualstudio.com/) dengan ekstensi Laravel

---

## 🪜 2. Langkah Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/Abdul-Faqih/Project-KUBIK.git
cd Project-KUBIK
````

### 2️⃣ Install Dependency Laravel

```bash
composer install
```

### 3️⃣ Install Dependency Frontend

```bash
npm install
```

### 4️⃣ Copy File `.env` dan Konfigurasi

```bash
cp .env.example .env
```

Atur koneksi database di file `.env`:

```env
DB_DATABASE=kubik
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Generate Key

```bash
php artisan key:generate
```

### 6️⃣ Migrasi Database + Smart Logic

```bash
php artisan migrate
```

Tambahkan data awal (dummy data), jalankan:

```bash
php artisan db:seed
```

### 7️⃣ Jalankan Tailwind CSS

```bash
npm run dev
```

### 8️⃣ Jalankan Server Laravel

```bash
php artisan serve
```

Akses melalui browser:

```
http://127.0.0.1:8000
```

---

## 🧠 3. Struktur Folder Penting

```
resources/
 └── views/
      ├── admin/
      │   ├── auth/               → halaman login & register admin
      │   ├── dashboard/
      │   │   ├── assets/         → halaman aset (list, detail, tambah)
      │   │   ├── layout/         → layout utama dashboard
      │   │   ├── partials/       → komponen tabel & card
      │   │   ├── home.blade.php  → dashboard utama
      │   │   ├── booking.blade.php → halaman peminjaman
      │   │   ├── assets.blade.php → list aset utama
app/
 └── Http/
      ├── Controllers/
      │   └── Admin/
      │       ├── DashboardController.php
      │       ├── AssetController.php
      │       ├── AssetMasterController.php
      │       └── Auth/
      │           └── AdminAuthController.php
      └── Models/
          ├── Asset.php
          ├── AssetMaster.php
          ├── Booking.php
          ├── Type.php
          ├── Category.php
database/
 ├── migrations/                   → struktur tabel & smart logic (trigger)
 ├── seeders/                      → dummy data (opsional)
routes/
 └── web.php                       → semua route utama aplikasi
```

---

## 🧑‍💻 4. Akun & Login Awal

Jika sudah ada seeder untuk admin, gunakan akun default berikut:

```
Email: admin@kubik.com
Password: 123456
```

Jika belum, buat akun manual melalui halaman:

```
http://127.0.0.1:8000/admin/register
```

---

## 🧱 5. Fitur Utama

### 🔸 Dashboard Admin

* Statistik aset, pinjaman, dan pengembalian
* Grafik distribusi aset (Rooms vs Items)
* Grafik aktivitas bulanan (Borrowed, Rejected, Late Return)
* Filter tanggal dinamis untuk activity table

### 🔸 Manajemen Aset

* Tambah, ubah, dan hapus aset
* Filter berdasarkan tipe & kategori
* Pencarian real-time (live search)
* Halaman detail aset dan detail aset master

### 🔸 Manajemen Peminjaman

* Persetujuan pinjaman otomatis (Pending → Approved → Completed)
* Notifikasi admin & user (Booking, Return, Rejection)
* Deteksi pengembalian terlambat (≥ 1 jam)

### 🔸 Smart Logic Database

* Auto-ID (AST-, AMT-, TYP-, CAT-, dll)
* Trigger update status otomatis saat booking & return
* Stock tracking otomatis (`stock_total` dan `stock_available`)

---

## 🧩 6. Cara Menambah Fitur Baru

### 🧱 Tambah Controller

```bash
php artisan make:controller Admin/ExampleController
```

### 🧱 Tambah Model + Migration

```bash
php artisan make:model Example -m
```

### 🧱 Update Route

Tambahkan di `routes/web.php`:

```php
Route::prefix('admin/dashboard')->group(function () {
    Route::get('/example', [ExampleController::class, 'index'])->name('admin.dashboard.example');
});
```

---

## 🤝 7. Cara Kontribusi

1. **Fork** repository ini
2. **Clone** hasil fork ke lokal

   ```bash
   git clone https://github.com/USERNAME/Project-KUBIK.git
   ```
3. Buat branch baru:

   ```bash
   git checkout -b branch-nama
   ```
4. Lakukan perubahan
5. Commit dan push:

   ```bash
   git add .
   git commit -m "Menambah fitur baru"
   git push origin fitur-baru
   ```
6. Buat **Pull Request** ke repository utama.

---

## 🛠️ 8. Troubleshooting

| Masalah                        | Penyebab                 | Solusi                                                               |
| ------------------------------ | ------------------------ | -------------------------------------------------------------------- |
| 404 Page Not Found             | Prefix route tidak cocok | Pastikan menggunakan `/admin/dashboard/...`                          |
| Error `1364 (stock_available)` | Kolom tidak diisi        | Tambahkan `'stock_available' => $request->stock_total` di controller |
| Tailwind tidak muncul          | Build tidak dijalankan   | Jalankan `npm run dev`                                               |
| Login gagal                    | Database kosong          | Jalankan `php artisan migrate:fresh --seed`                          |

---

## 👥 9. Tim Pengembang

| Nama                                   | Peran                               | Kontak                                   |
| -------------------------------------- | ----------------------------------- | ---------------------------------------- |
| **Abdul Faqih**                        | Fullstack Developer / Project Owner | [GitHub](https://github.com/Abdul-Faqih) |
| Tambahkan Nama Kamu  | Frontend / Backend                  | —                                        |

---

## 📄 Lisensi

Project ini dikembangkan untuk keperluan akademik.
Silakan gunakan dan modifikasi dengan mencantumkan atribusi ke pengembang asli.

---
