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
        Schema::create('people_readinesses', function (Blueprint $table) {
            $table->id();
            $table->string('posisi');
            $table->integer('Fullfillment_plan');
            $table->integer('pou_pou_plan');
            $table->integer('HSE_plan');
            $table->integer('Leadership_plan');
            $table->integer('Improvement_plan');
            $table->string('Quality_plan');
            $table->string('Quantity_plan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_readinesses');
    }
};
