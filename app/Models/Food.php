<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'food_category_id',
    'name',
    'slug',
    'base_unit',
    'base_quantity',
    'calories',
    'protein',
    'carbohydrates',
    'fat',
    'fiber',
    'source',
    'notes',
    'is_active',
])]
class Food extends Model
{
    protected $table = 'foods';

    /**
     * @return BelongsTo<FoodCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }

    /**
     * @return HasMany<NutritionPlanItem, $this>
     */
    public function nutritionPlanItems(): HasMany
    {
        return $this->hasMany(NutritionPlanItem::class);
    }

    /**
     * Get a macro projection for a custom quantity based on the food's base quantity.
     *
     * @return array{calories: float, protein: float, carbohydrates: float, fat: float}
     */
    public function macrosFor(float $quantity): array
    {
        $factor = $this->base_quantity > 0 ? $quantity / (float) $this->base_quantity : 0;

        return [
            'calories' => round((float) $this->calories * $factor, 2),
            'protein' => round((float) $this->protein * $factor, 2),
            'carbohydrates' => round((float) $this->carbohydrates * $factor, 2),
            'fat' => round((float) $this->fat * $factor, 2),
        ];
    }
}
