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
    protected function casts(): array
    {
        return [
            'plan_date' => 'date',
        ];
    }

    /**
     * @return array{calories: float, protein: float, carbohydrates: float, fat: float}
     */
    public function macroTotals(): array
    {
        $items = $this->relationLoaded('meals')
            ? $this->meals->flatMap(fn (NutritionPlanMeal $meal) => $meal->items)
            : $this->meals()->with('items')->get()->flatMap(fn (NutritionPlanMeal $meal) => $meal->items);

        return [
            'calories' => round((float) $items->sum('calories'), 2),
            'protein' => round((float) $items->sum('protein'), 2),
            'carbohydrates' => round((float) $items->sum('carbohydrates'), 2),
            'fat' => round((float) $items->sum('fat'), 2),
        ];
    }

    public function foodItemsCount(): int
    {
        if ($this->relationLoaded('meals')) {
            return (int) $this->meals->sum(fn (NutritionPlanMeal $meal) => $meal->items->count());
        }

        return (int) $this->meals()
            ->withCount('items')
            ->get()
            ->sum('items_count');
    }

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
