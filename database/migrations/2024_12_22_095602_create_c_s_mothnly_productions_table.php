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
        Schema::create('c_s_mothnly_productions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('dbcm_ob', 15, 2)->nullable();
            $table->integer('mbcm_ob', 15, 2)->nullable();
            $table->integer('ybcm_ob', 15, 2)->nullable();
            $table->integer('dcoal_ton', 15, 2)->nullable();
            $table->integer('mcoal_ton', 15, 2)->nullable();
            $table->integer('ycoal_ton', 15, 2)->nullable();
            $table->integer('dactual', 15, 2)->nullable();
            $table->integer('mactual', 15, 2)->nullable();
            $table->integer('yactual', 15, 2)->nullable();
            $table->integer('dcoal', 15, 2)->nullable();
            $table->integer('mcoal', 15, 2)->nullable();
            $table->integer('ycoal', 15, 2)->nullable();
            $table->integer('bargings', 15, 2)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable(); 
            $table->string('deleted_by')->nullable();           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_s_mothnly_productions');
    }
};
