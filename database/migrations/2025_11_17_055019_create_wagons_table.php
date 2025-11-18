<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\WagonTypeEnum, App\Enums\WagonServiceClassEnum;

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
            $table->enum('type', array_column(WagonTypeEnum::cases(), 'value'));
            $table->enum('service_class', array_column(WagonServiceClassEnum::cases(), 'value'));
            $table->integer('places')->default(0);
            $table->jsonb('features');
            $table->text('description');
            $table->integer('seats_total');
            $table->enum('direction', ['left', 'right'])->default('left');
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
