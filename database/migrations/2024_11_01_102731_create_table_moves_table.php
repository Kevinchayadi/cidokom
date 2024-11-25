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
        Schema::create('table_moves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('current_pen');
            $table->unsignedBigInteger('destination_pen');
            $table->unsignedBigInteger('totalMale');
            $table->unsignedBigInteger('totalFemale');
            $table->decimal('maleCost',15,2)->nullable();
            $table->decimal('femaleCost',15,2)->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_moves');
    }
};
