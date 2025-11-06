<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('booking_assets', function (Blueprint $table) {
        $table->string('id_booking', 10);
        $table->string('id_asset', 10);

        $table->foreign('id_booking')->references('id_booking')->on('bookings')->cascadeOnDelete();
        $table->foreign('id_asset')->references('id_asset')->on('assets')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_assets');
    }
};
