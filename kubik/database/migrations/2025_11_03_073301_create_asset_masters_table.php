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
        Schema::create('asset_masters', function (Blueprint $table) {
            $table->string('id_master', 10)->primary();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('image_asset')->nullable();
            $table->string('id_category', 10);
            $table->string('id_type', 10);
            $table->integer('stock_total');
            $table->integer('stock_available')->default(0);
            $table->timestamps();

            $table->foreign('id_category')->references('id_category')->on('categories')->cascadeOnDelete();
            $table->foreign('id_type')->references('id_type')->on('types')->cascadeOnDelete();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_masters');
    }
};
