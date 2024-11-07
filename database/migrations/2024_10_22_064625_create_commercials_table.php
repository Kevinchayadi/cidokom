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
        Schema::create('commercials', function (Blueprint $table) {
            $table->string('id_commercial')->primary(); 
            $table->unsignedBigInteger('id_pen')->nullable(); 
            $table->date('entryDate')->nullable();
            $table->integer('entry_population')->nullable();
            $table->integer('last_population')->nullable();
            $table->integer('age')->nullable()->nullable();
            $table->decimal('total_cost', 15, 2)->nullable(); 
            $table->decimal('unit_Cost', 15, 2)->nullable(); 
            $table->decimal('cost_total', 15, 2)->nullable();
            $table->decimal('cost_unit', 15, 2)->nullable();
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
        Schema::dropIfExists('commercials');
    }
};
