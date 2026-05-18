<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'nutrition_plan_meal_id',
    'food_id',
    'food_name',
    'quantity',
    'unit',
    'calories',
    'protein',
    'carbohydrates',
    'fat',
    'sort_order',
])]
class NutritionPlanItem extends Model
{
    /**
     * @return BelongsTo<NutritionPlanMeal, $this>
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(NutritionPlanMeal::class, 'nutrition_plan_meal_id');
    }

    /**
     * @return BelongsTo<Food, $this>
     */
    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
