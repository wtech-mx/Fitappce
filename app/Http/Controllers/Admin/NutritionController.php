<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use Illuminate\View\View;

class NutritionController extends Controller
{
    public function create(): View
    {
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
                ])->all(),
            ])
            ->all();

        return view('fitapp.admin.nutricion-crear', compact('catalogs'));
    }
}
