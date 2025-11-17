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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('from');
            $table->datetime('from_date');
            $table->string('to');
            $table->datetime('to_date');
            $table->integer('adult_person')->default(0);
            $table->integer('child_with_place')->default(0);
            $table->integer('child_without_place')->default(0);
            $table->integer('place_for_invalid')->default(0);
            $table->integer('place_for_family')->default(0);
            $table->boolean('pets')->default(false);
            $table->boolean('car')->default(false);
            $table->boolean('motorcycle')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
