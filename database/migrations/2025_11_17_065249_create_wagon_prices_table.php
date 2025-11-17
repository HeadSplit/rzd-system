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
        Schema::create('wagon_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wagon_id');
            $table->foreign('wagon_id')->references('id')->on('wagons')->onDelete('cascade');
            $table->decimal('min_price', 8, 2, false);
            $table->decimal('max_price', 8, 2, false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wagon_prices');
    }
};
