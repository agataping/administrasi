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
        Schema::create('infrastructure_readinesses', function (Blueprint $table) {
            $table->id();
            $table->string('ProjectName');
            $table->integer('Preparation')->nullable();;
            $table->integer('Construction')->nullable();;
            $table->integer('Commissiong')->nullable();;
            $table->integer('KelayakanBangunan');
            $table->integer('Kelengakapan');
            $table->integer('Kebersihan');
            $table->string('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_readinesses');
    }
};
