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
        Schema::create('hatchery_details', function (Blueprint $table) {
            $table->id();
            $table->string('id_hatchery'); // Primary Key
            $table->integer('total_setting')->nullable();
            $table->integer('infertile')->nullable();
            $table->integer('explode')->nullable();
            $table->integer('hatcher')->nullable();
            $table->integer('dead_in_egg')->nullable();
            $table->integer('hatchability')->nullable();
            $table->integer('doc_afkir')->nullable();
            $table->integer('saleable')->nullable();
            $table->string('inputBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hatchery_details');
    }
};
