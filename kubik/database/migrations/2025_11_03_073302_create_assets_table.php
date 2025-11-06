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
    Schema::create('assets', function (Blueprint $table) {
        $table->string('id_asset', 10)->primary();
        $table->string('id_master', 10);
        $table->enum('status', ['Available', 'Borrowed', 'Maintenance'])->default('Available');
        $table->enum('condition', ['Good', 'Minor Damage', 'Damaged', 'Lost'])->default('Good');
        $table->timestamp('updated_at')->useCurrent();

        $table->foreign('id_master')->references('id_master')->on('asset_masters')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
