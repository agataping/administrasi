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
        Schema::create('detailabarugis', function (Blueprint $table) {
            $table->id();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable(); 
            $table->string('deleted_by')->nullable(); 
            $table->decimal('nominalactual',20,2)->nullable();
            $table->decimal('nominalplan',20,2)->nullable();
            $table->date('tanggal');
            $table->string('desc');
            $table->foreignId('sub_id')->constrained('sub_labarugis')->onDelete('cascade');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailabarugis');
    }
};
