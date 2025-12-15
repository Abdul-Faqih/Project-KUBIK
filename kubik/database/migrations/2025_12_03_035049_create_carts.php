<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            // Kolom Primary Key untuk tabel carts
            $table->id();

            // --- Foreign Key ke Tabel USERS ---

            // 1. Definisikan kolom lokal carts.id_user
            // Harus sama dengan tipe data Primary Key di tabel users (bigint(20) unsigned)
            $table->unsignedBigInteger('id_user');

            // 2. Definisikan Constraint Foreign Key
            // MERUJUK ke kolom 'id_user' di tabel 'users' (ASUMSI nama tabelnya 'users')
            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            // --- Foreign Key ke Tabel ASSETS ---

            // 1. Definisikan kolom lokal carts.id_asset
            // Harus sama dengan tipe data Primary Key di tabel assets (varchar(10))
            $table->string('id_asset', 10);

            // 2. Definisikan Constraint Foreign Key
            // MERUJUK ke kolom 'id_asset' di tabel 'assets' (ASUMSI nama tabelnya 'assets')
            $table->foreign('id_asset')
                ->references('id_asset')
                ->on('assets')
                ->onDelete('cascade');

            // Constraint: Mencegah user memasukkan aset yang sama dua kali
            $table->unique(['id_user', 'id_asset']);

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};