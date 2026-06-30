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
        Schema::create('hair_experts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('specialty'); // e.g. Dermatologi, Hair Stylist
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('price'); // consultation booking price
            $table->text('profile')->nullable();
            $table->string('experience'); // e.g. "8 tahun pengalaman"
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hair_experts');
    }
};
