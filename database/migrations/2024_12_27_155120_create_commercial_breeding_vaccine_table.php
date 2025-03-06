<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commercial_breeding_vaccine', function (Blueprint $table) {
            $table->id();
            $table->string('id_commercial')->nullable();
            $table->string('id_breeding')->nullable();
            $table->unsignedBigInteger('vaccine_id'); // Assuming 'vaccine_id' is also a string, adjust if necessary

            // Define foreign key constraints for string columns
            $table->foreign('id_commercial')->references('id_commercial')->on('commercials')->onDelete('cascade');
            $table->foreign('id_breeding')->references('id_breeding')->on('breedings')->onDelete('cascade');
            $table->foreign('vaccine_id')->references('id')->on('vaksins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_breeding_vaccine');
    }
};
