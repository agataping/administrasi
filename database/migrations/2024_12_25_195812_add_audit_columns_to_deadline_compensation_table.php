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
        Schema::table('deadline_compensation', function (Blueprint $table) {
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable(); 
            $table->string('deleted_by')->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deadline_compensation', function (Blueprint $table) {
            //
        });
    }
};
