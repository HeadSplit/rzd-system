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
        Schema::create('route_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')
                ->constrained('routes')
                ->cascadeOnDelete();

            $table->foreignId('station_id')
                ->constrained('stations')
                ->cascadeOnDelete();

            $table->unsignedInteger('order')
                ->comment('Позиция станции в маршруте');

            $table->time('arrival_time')->nullable();
            $table->time('departure_time')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_stations');
    }
};
