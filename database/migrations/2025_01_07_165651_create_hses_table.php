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
        Schema::create('hses', function (Blueprint $table) {
            $table->id();
            $table->string('nameindikator');
            $table->string('target');
            $table->string('nilai');
            $table->string('indikator')->nullable();
            $table->string('keterangan');
            $table->date('date');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable(); 
            $table->string('deleted_by')->nullable();     
            $table->foreignId('kategori_id')->constrained('kategori_hses')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hses');
    }
};
