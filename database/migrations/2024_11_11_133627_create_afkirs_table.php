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
            $table->integer('population');
            $table->decimal('cost_unit', 15, 2)->nullable();
            $table->string('inputBy');
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
