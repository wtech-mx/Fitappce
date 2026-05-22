<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NutritionController extends Controller
{
    public function create(Request $request): View
    {
        $excludedFoodIds = collect($request->input('excluded_food_ids', []))
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->unique()
            ->values();

        $excludedFoods = Food::with('category')
            ->whereIn('id', $excludedFoodIds)
            ->orderBy('name')
            ->get()
            ->map(fn (Food $food): array => [
                'id' => $food->id,
                'name' => $food->name,
                'base_unit' => $food->base_unit,
                'category' => $food->category?->name ?: 'Catalogo',
            ])
            ->all();

        $catalogs = FoodCategory::with(['foods' => function ($query) {
            $query->where('is_active', true)->orderBy('name');
        }])
            ->orderBy('sort_order')
            ->get()
            ->map(fn (FoodCategory $category): array => [
                'name' => $category->name,
                'icon' => $category->icon ?: 'bi-circle',
                'items' => $category->foods
                    ->take(6)
                    ->map(fn ($food) => "{$food->name} ({$food->base_unit})")
                    ->join(', '),
                'foods' => $category->foods->map(fn ($food): array => [
                    'id' => $food->id,
                    'name' => $food->name,
                    'base_unit' => $food->base_unit,
                    'base_quantity' => (float) $food->base_quantity,
                    'calories' => (float) $food->calories,
                    'protein' => (float) $food->protein,
                    'carbohydrates' => (float) $food->carbohydrates,
                    'fat' => (float) $food->fat,
                    'is_excluded' => $excludedFoodIds->contains((int) $food->id),
                ])->all(),
            ])
            ->all();

        return view('fitapp.admin.nutricion-crear', compact('catalogs', 'excludedFoods'));
    }
}
