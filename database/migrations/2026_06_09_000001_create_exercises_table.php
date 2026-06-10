<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('parent_category')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('level')->nullable();
            $table->string('primary_muscle')->nullable();
            $table->string('muscles')->nullable();
            $table->text('description')->nullable();
            $table->text('purpose')->nullable();
            $table->text('coach_notes')->nullable();
            $table->text('common_mistakes')->nullable();
            $table->string('demo_type')->default('video');
            $table->string('demo_path')->nullable();
            $table->boolean('allows_evidence')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('workout_plan_exercises', function (Blueprint $table) {
            $table->foreignId('exercise_id')
                ->nullable()
                ->after('workout_plan_day_id')
                ->constrained('exercises')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('workout_plan_exercises', function (Blueprint $table) {
            $table->dropConstrainedForeignId('exercise_id');
        });

        Schema::dropIfExists('exercises');
    }
};
