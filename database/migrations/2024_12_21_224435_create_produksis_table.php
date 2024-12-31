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
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->decimal('ob_bcm', 10, 2)->nullable();
            $table->decimal('ob_wh', 10, 2)->nullable();
            $table->decimal('ob_pty', 10, 2)->nullable();
            $table->decimal('ob_distance', 10, 2)->nullable();
            $table->decimal('coal_mt', 10, 2)->nullable();
            $table->decimal('coal_wh', 10, 2)->nullable();
            $table->decimal('coal_pty', 10, 2)->nullable();
            $table->decimal('coal_distance', 10, 2)->nullable();
            $table->decimal('general_hours', 10, 2)->nullable();
            $table->decimal('stby_hours', 10, 2)->nullable();
            $table->decimal('bd_hours', 10, 2)->nullable();
            $table->decimal('rental_hours', 10, 2)->nullable();
            $table->decimal('pa', 10, 2)->nullable();
            $table->decimal('mohh', 10, 2)->nullable();
            $table->decimal('ua', 10, 2)->nullable();
            $table->decimal('ltr_total', 10, 2)->nullable();
            $table->decimal('ltr_wh', 10, 2)->nullable();
            $table->decimal('ltr', 10, 2)->nullable();
            $table->decimal('ltr_coal', 10, 2)->nullable();
            $table->decimal('l_hm', 10, 2)->nullable();
            $table->decimal('l_bcm', 10, 2)->nullable();
            $table->decimal('l_mt', 10, 2)->nullable();
            $table->string('tot_pa')->nullable();
            $table->string('tot_ua')->nullable();
            $table->string('tot_ma')->nullable();
            $table->string('eu')->nullable();
            $table->string('pa_plan')->nullable();
            $table->string('ua_plan')->nullable();
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
