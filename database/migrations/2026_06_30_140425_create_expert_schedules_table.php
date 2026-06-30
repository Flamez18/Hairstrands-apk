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
        Schema::create('expert_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hair_expert_id')->constrained('hair_experts')->onDelete('cascade');
            $table->date('date');
            $table->string('time_slot'); // e.g. "09:00", "10:00", "11:00", "13:00", etc.
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_schedules');
    }
};
