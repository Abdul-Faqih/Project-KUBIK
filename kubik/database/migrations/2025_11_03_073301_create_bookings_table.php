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
    Schema::create('bookings', function (Blueprint $table) {
        $table->string('id_booking', 10)->primary();
        $table->unsignedBigInteger('id_user');
        $table->unsignedBigInteger('id_admin')->nullable();
        $table->dateTime('start_time');
        $table->timestamp('end_time');
        $table->timestamp('return_at')->nullable();
        $table->float('late_return')->nullable();
        $table->string('attachment')->nullable();
        $table->text('note')->nullable();
        $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Completed'])->default('Pending');
        $table->timestamps();

        $table->foreign('id_user')->references('id_user')->on('users');
        $table->foreign('id_admin')->references('id_admin')->on('admins');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
