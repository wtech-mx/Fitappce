<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'name',
    'plan_date',
    'goal',
    'meals_per_day',
    'target_calories',
    'target_protein',
    'target_carbohydrates',
    'target_fat',
    'daily_water',
    'status',
    'preference',
    'notes',
])]
class NutritionPlan extends Model
{
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<NutritionPlanMeal, $this>
     */
    public function meals(): HasMany
    {
        return $this->hasMany(NutritionPlanMeal::class)->orderBy('sort_order');
    }
}
