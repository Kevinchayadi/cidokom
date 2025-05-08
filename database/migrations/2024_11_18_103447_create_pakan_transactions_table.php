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
        Schema::create('pakan_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pakan');
            $table->decimal('first_stock', 15, 2);
            $table->decimal('qty', 15, 2);
            $table->decimal('harga_pembelian', 15,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakan_transactions');
    }
};
