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
        Schema::create('deadline_compensation', function (Blueprint $table) {
            $table->id();
            $table->string('Keterangan');
            $table->string('MasaSewa');
            $table->string('Nominalsewa');
            $table->string('ProgresTahun');
            $table->string('JatuhTempo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deadline_compensation');
    }
};
