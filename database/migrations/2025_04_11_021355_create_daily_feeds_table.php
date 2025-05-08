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
        Schema::create('daily_feeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pen');
            $table->unsignedBigInteger('id_pakan');
            $table->unsignedBigInteger('id_pakan');
            $table->decimal('stock_feed',15,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_feeds');
    }
};
