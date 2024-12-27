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
        Schema::create('p_o_ayams', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_ayam');
            $table->string('nama_pembeli',255)->nullable();
            $table->decimal('total_harga',15,2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_o_ayams');
    }
};
