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
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('name')->unique();
            $table->foreignId('start_station_id')->nullable()->constrained('stations')->onDelete('cascade');
            $table->foreignId('end_station_id')->nullable()->constrained('stations')->onDelete('cascade');
            $table->unique(['start_station_id', 'end_station_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trains');
    }
};
