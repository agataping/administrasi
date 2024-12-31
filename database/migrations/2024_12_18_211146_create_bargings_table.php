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
        Schema::create('bargings', function (Blueprint $table) {
            $table->id();
            $table->string('laycan');
            $table->string('namebarge');
            $table->string('surveyor');
            $table->string('portloading');
            $table->string('portdishcharging');
            $table->string('notifyaddres');
            $table->date('initialsurvei');
            $table->date('finalsurvey');
            $table->decimal('quantity', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bargings');
    }
};
