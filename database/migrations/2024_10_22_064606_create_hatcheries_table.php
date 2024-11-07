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
        Schema::create('hatcheries', function (Blueprint $table) {
            $table->string('id_hatchery')->unique()->primary();
            $table->unsignedBigInteger('id_pen');
            $table->string('id_machine');
            $table->date('setting_date')->nullable();
            $table->date('candling_date')->nullable();
            $table->date('pull_chicken_date')->nullable();
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
        Schema::dropIfExists('hatcheries');
    }
};
