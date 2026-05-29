<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_plans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->date('plan_date')->nullable();
            $table->string('goal')->nullable();
            $table->string('level')->nullable();
            $table->string('place')->nullable();
            $table->unsignedSmallInteger('days_per_week')->default(4);
            $table->string('duration')->nullable();
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

        Schema::create('workout_plan_days', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workout_plan_id')->constrained()->cascadeOnDelete();
            $table->string('day_name');
            $table->string('focus')->nullable();
            $table->string('estimated_time')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('workout_plan_exercises', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workout_plan_day_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('block_type')->default('Individual');
            $table->string('sets')->nullable();
            $table->string('reps')->nullable();
            $table->string('rest')->nullable();
            $table->string('tempo')->nullable();
            $table->boolean('requires_evidence')->default(false);
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['workout_plan_day_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plan_exercises');
        Schema::dropIfExists('workout_plan_days');
        Schema::dropIfExists('workout_plans');
    }
};
