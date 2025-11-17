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
        Schema::create('wagons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id');
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
            $table->integer('number');
            $table->enum('type', WagonTypeEnum::cases())->default('default');
            $table->enum('service_class', WagonServiceClassEnum::cases())->default('default');
            $table->jsob('features');
            $table->text('description');
            $table->integer('seats_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wagons');
    }
};
