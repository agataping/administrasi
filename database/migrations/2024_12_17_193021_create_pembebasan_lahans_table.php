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
        Schema::create('pembebasan_lahans', function (Blueprint $table) {
            $table->id();
            $table->string('NamaPemilik');
            $table->double('LuasLahan');
            $table->string('KebutuhanLahan');
            $table->string('Progress');
            $table->string('Status')->nullable();
            $table->string('Achievement');
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
        Schema::dropIfExists('pembebasan_lahans');
    }
};
