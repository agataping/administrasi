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
        Schema::create('pica_over_coal', function (Blueprint $table) {
            $table->id();
            $table->string('cause');
            $table->string('problem'); 
            $table->string('corectiveaction'); 
            $table->string('duedate'); 
            $table->string('pic'); 
            $table->string('remerks'); 
            $table->string('status'); 
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
        Schema::dropIfExists('pica_over_coal');
    }
};
