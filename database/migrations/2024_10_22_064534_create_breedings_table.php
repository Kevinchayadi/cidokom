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
        Schema::create('breedings', function (Blueprint $table) {
            $table->string('id_breeding')->unique()->primary();
            $table->unsignedBigInteger('id_pen');
            $table->string('code_ayam_jantan');
            $table->string('code_ayam_betina');
            $table->integer('jumlah_jantan');
            $table->integer('jumlah_betina');
            $table->integer('age');
            $table->string('move_to')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breedings');
    }
};
