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
        Schema::create('pens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kandang');
            $table->string('code_pen'); 
            $table->unsignedBigInteger('total_egg')->nullable();
            $table->unsignedBigInteger('total_cost')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pens');
    }
};
