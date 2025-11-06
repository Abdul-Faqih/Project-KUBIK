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
    Schema::create('user_notifications', function (Blueprint $table) {
        $table->id('id_notification');
        $table->unsignedBigInteger('id_user');
        $table->text('message');
        $table->boolean('is_read')->default(false);
        $table->timestamps();

        $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
