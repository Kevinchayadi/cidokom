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
        Schema::create('commercial_details', function (Blueprint $table) {
            $table->id();
            $table->string('id_commercial'); 
            $table->date('date')->nullable();
            $table->integer('begining_population')->nullable();
            $table->integer('last_population')->nullable();
            $table->integer('depreciation_die')->nullable();
            $table->integer('depreciation_afkir')->nullable();
            $table->integer('depreciation_panen')->nullable();
            $table->integer('move_to')->nullable();
            $table->integer('total_move')->nullable();
            $table->integer('receive_from')->nullable();
            $table->integer('total_receive')->nullable();
            $table->integer('feed')->nullable();
            $table->string('feed_name')->nullable();
            $table->string('inputBy');
            $table->string('id_vaksin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_details');
    }
};
