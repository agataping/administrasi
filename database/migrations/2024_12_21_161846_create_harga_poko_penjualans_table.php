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
        Schema::create('harga_poko_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('category'); 
            $table->string('subcategory');
            $table->string('item')->nullable();
            $table->bigInteger('plan')->nullable(); 
            $table->bigInteger('realization')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_poko_penjualans');
    }
};
