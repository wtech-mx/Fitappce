<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nutrition_plan_id', 'name', 'sort_order'])]
class NutritionPlanMeal extends Model
{
    /**
     * @return BelongsTo<NutritionPlan, $this>
     */
    public function nutritionPlan(): BelongsTo
    {
        return $this->belongsTo(NutritionPlan::class);
    }

    /**
     * @return HasMany<NutritionPlanItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(NutritionPlanItem::class);
    }
}
