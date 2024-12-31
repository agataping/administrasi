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
        Schema::create('neracas', function (Blueprint $table) {

        $table->id();
        $table->string('description');
        $table->biginteger('nominal'); 
        $table->foreignId('category_id')->constrained('Kategory_neracas')->onDelete('cascade');
        $table->timestamps();
    });

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
