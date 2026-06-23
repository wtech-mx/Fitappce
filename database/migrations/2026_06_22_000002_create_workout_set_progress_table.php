<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_set_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workout_plan_day_id')->constrained()->cascadeOnDelete();
            $table->string('progress_key', 80);
            $table->date('progress_date');
            $table->unsignedInteger('completed_sets')->default(0);
            $table->timestamp('rest_started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'workout_plan_day_id', 'progress_key', 'progress_date'], 'workout_progress_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_set_progress');
    }
};
