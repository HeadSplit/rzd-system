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
            $table->string('name');
            $table->string('start_stantion')->nullable();
            $table->foreign('start_stantion')->references('name')->on('stantions')->onDelete('cascade');
            $table->string('end_stantion')->nullable();
            $table->foreign('end_stantion')->references('name')->on('stantions')->onDelete('cascade');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
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
