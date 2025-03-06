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
        Schema::create('afkirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pen');
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->decimal('male_cost', 15, 2)->nullable();
            $table->decimal('female_cost', 15, 2)->nullable();
            $table->integer('male_die')->nullable();
            $table->integer('female_die')->nullable();
            $table->integer('male_sale')->nullable();
            $table->integer('female_sale')->nullable();
            $table->integer('feed_male')->nullable();
            $table->integer('feed_female')->nullable();
            $table->integer('male_come')->nullable();
            $table->integer('female_come')->nullable();
            $table->integer('male_out')->nullable();
            $table->integer('female_out')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afkirs');
    }
};
