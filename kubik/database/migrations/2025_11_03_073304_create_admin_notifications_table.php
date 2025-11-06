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
    Schema::create('admin_notifications', function (Blueprint $table) {
        $table->id('id_notification');
        $table->unsignedBigInteger('id_admin');
        $table->text('message');
        $table->boolean('is_read')->default(false);
        $table->timestamps();

        $table->foreign('id_admin')->references('id_admin')->on('admins')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
