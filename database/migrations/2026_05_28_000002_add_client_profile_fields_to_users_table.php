<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('role');
            $table->unsignedTinyInteger('age')->nullable()->after('phone');
            $table->string('gender')->nullable()->after('age');
            $table->string('status')->default('prospect')->after('gender');
            $table->string('goal')->nullable()->after('status');
            $table->string('service')->nullable()->after('goal');
            $table->string('plan_type')->nullable()->after('service');
            $table->string('training_level')->nullable()->after('plan_type');
            $table->unsignedTinyInteger('training_days')->nullable()->after('training_level');
            $table->string('training_place')->nullable()->after('training_days');
            $table->text('medical_notes')->nullable()->after('training_place');
            $table->unsignedTinyInteger('meals_per_day')->nullable()->after('medical_notes');
            $table->string('nutrition_restriction')->nullable()->after('meals_per_day');
            $table->string('difficult_schedule')->nullable()->after('nutrition_restriction');
            $table->json('excluded_food_ids')->nullable()->after('difficult_schedule');
            $table->decimal('initial_weight', 6, 2)->nullable()->after('excluded_food_ids');
            $table->decimal('initial_body_fat', 5, 2)->nullable()->after('initial_weight');
            $table->decimal('initial_lean_mass', 6, 2)->nullable()->after('initial_body_fat');
            $table->decimal('initial_waist', 6, 2)->nullable()->after('initial_lean_mass');
            $table->decimal('initial_chest', 6, 2)->nullable()->after('initial_waist');
            $table->decimal('goal_chest', 6, 2)->nullable()->after('initial_chest');
            $table->decimal('initial_hip', 6, 2)->nullable()->after('goal_chest');
            $table->decimal('goal_hip', 6, 2)->nullable()->after('initial_hip');
            $table->decimal('initial_arm', 6, 2)->nullable()->after('goal_hip');
            $table->decimal('goal_arm', 6, 2)->nullable()->after('initial_arm');
            $table->decimal('initial_thigh', 6, 2)->nullable()->after('goal_arm');
            $table->decimal('goal_thigh', 6, 2)->nullable()->after('initial_thigh');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'age',
                'gender',
                'status',
                'goal',
                'service',
                'plan_type',
                'training_level',
                'training_days',
                'training_place',
                'medical_notes',
                'meals_per_day',
                'nutrition_restriction',
                'difficult_schedule',
                'excluded_food_ids',
                'initial_weight',
                'initial_body_fat',
                'initial_lean_mass',
                'initial_waist',
                'initial_chest',
                'goal_chest',
                'initial_hip',
                'goal_hip',
                'initial_arm',
                'goal_arm',
                'initial_thigh',
                'goal_thigh',
            ]);
        });
    }
};
