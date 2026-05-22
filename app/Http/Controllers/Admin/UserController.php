<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use Illuminate\View\View;

class UserController extends Controller
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
                'foods' => $category->foods->map(fn ($food): array => [
                    'id' => $food->id,
                    'name' => $food->name,
                    'base_unit' => $food->base_unit,
                    'category' => $category->name,
                ])->all(),
            ])
            ->all();

        return view('fitapp.admin.usuarios-alta', compact('catalogs'));
    }
}
