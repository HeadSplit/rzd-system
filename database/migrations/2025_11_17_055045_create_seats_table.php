<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\SeatTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wagon_id');
            $table->foreign('wagon_id')->references('id')->on('wagons')->onDelete('cascade');
            $table->integer('number');
            $table->enum('type', array_column(SeatTypeEnum::cases(), 'value'))->default('default');
            $table->boolean('is_available')->default(true);
            $table->decimal('price', 8, 2, false);
            $table->unique(['wagon_id', 'number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
