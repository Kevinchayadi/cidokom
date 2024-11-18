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
        Schema::create('breeding_details', function (Blueprint $table) {
            $table->id();
            $table->string('id_breeding');
            $table->integer('last_male')->nullable();
            $table->integer('last_female')->nullable();
            $table->integer('female_die')->nullable();
            $table->integer('female_reject')->nullable();
            $table->integer('male_die')->nullable();
            $table->integer('male_reject')->nullable();
            $table->integer('egg_morning')->nullable();
            $table->integer('egg_afternoon')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->integer('broken')->nullable();
            $table->integer('abnormal')->nullable();
            $table->integer('sale')->nullable();
            $table->integer('total_egg')->nullable();
            $table->integer('move_to')->nullable();
            $table->integer('total_female_move')->nullable();
            $table->integer('total_male_move')->nullable();
            $table->integer('receive_from')->nullable();
            $table->integer('total_female_receive')->nullable();
            $table->integer('total_male_receive')->nullable();
            $table->decimal('cost_unit', 15, 2)->nullable();
            $table->decimal('cost_total', 15, 2)->nullable();
            $table->string('feed')->nullable();
            $table->string('feed_name')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->string('inputBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breeding_details');
    }
};
