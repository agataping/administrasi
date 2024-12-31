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
        Schema::table('people_readinesses', function (Blueprint $table) {
            $table->integer('pou_pou_actual');
            $table->integer('HSE_actual');
            $table->integer('Leadership_actual');
            $table->integer('Improvement_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people_readinesses', function (Blueprint $table) {
            //
        });
    }
};
