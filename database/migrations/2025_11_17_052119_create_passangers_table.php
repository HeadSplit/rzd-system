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
        Schema::create('passangers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic');
            $table->boolean('has_patronymic')->default(false);
            $table->date('birth_date');
            $table->string('document');
            $table->string('series');
            $table->string('number');
            $table->string('gender');
            $table->boolean('is_medical')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passangers');
    }
};
