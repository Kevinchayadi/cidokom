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
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_Penjualan');
            $table->unsignedBigInteger('id_pembeli');
            $table->integer('jumlah_ayam');
            $table->unsignedBigInteger('id_ayam');
            $table->decimal('harga',15,2)->nullable();
            $table->decimal('total_harga',15,2)->nullable();
            $table->string('status',20)->default('pending');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_transactions');
    }
};
