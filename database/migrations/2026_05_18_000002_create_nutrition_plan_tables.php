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
        Schema::create('nutrition_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->date('plan_date')->nullable();
            $table->string('goal')->nullable();
            $table->unsignedSmallInteger('meals_per_day')->default(5);
            $table->decimal('target_calories', 8, 2)->default(0);
            $table->decimal('target_protein', 8, 2)->default(0);
            $table->decimal('target_carbohydrates', 8, 2)->default(0);
            $table->decimal('target_fat', 8, 2)->default(0);
            $table->string('daily_water')->nullable();
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

        Schema::create('nutrition_plan_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('nutrition_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->nullable()->constrained('foods')->nullOnDelete();
            $table->string('food_name');
            $table->decimal('quantity', 8, 2)->default(1);
            $table->string('unit')->default('porcion');
            $table->decimal('calories', 8, 2)->default(0);
            $table->decimal('protein', 8, 2)->default(0);
            $table->decimal('carbohydrates', 8, 2)->default(0);
            $table->decimal('fat', 8, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['nutrition_plan_meal_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_plan_items');
        Schema::dropIfExists('nutrition_plan_meals');
        Schema::dropIfExists('nutrition_plans');
    }
};
