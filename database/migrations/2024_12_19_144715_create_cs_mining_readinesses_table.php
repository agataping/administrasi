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
        Schema::create('cs_mining_readinesses', function (Blueprint $table) {
            $table->id();
            $table->string('Description');
            $table->string('NomerLegalitas')->nullable();
            $table->string('status');
            $table->date('tanggal')->nullable();
            $table->string('berlaku');
            $table->string('Achievement');
            $table->string('nomor')->nullable();
            $table->string('filling')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cs_mining_readinesses');
    }
};
