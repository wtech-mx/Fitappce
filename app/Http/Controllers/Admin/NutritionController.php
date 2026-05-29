<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\NutritionPlan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NutritionController extends Controller
{
    public function index(Request $request): View
    {
        $plans = NutritionPlan::with(['user', 'meals.items'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('goal', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($query) => $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->get();

        return view('fitapp.admin.nutricion', compact('plans'));
    }

    public function create(Request $request): View
    {
        $users = User::query()
            ->where('role', 'user')
            ->orderBy('name')
            ->get();
        $selectedUser = $request->filled('user')
            ? $users->firstWhere('id', $request->integer('user'))
            : $users->first();

        $excludedFoodIds = collect($request->input('excluded_food_ids', []))
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->unique()
            ->values();

        if ($selectedUser && $excludedFoodIds->isEmpty()) {
            $excludedFoodIds = collect($selectedUser->excluded_food_ids ?? [])
                ->filter()
                ->map(fn ($id): int => (int) $id)
                ->unique()
                ->values();
        }

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

        $mode = 'create';
        $plan = null;

        return view('fitapp.admin.nutricion-crear', compact('catalogs', 'excludedFoods', 'users', 'selectedUser', 'mode', 'plan'));
    }

    public function show(NutritionPlan $nutrition): View
    {
        $nutrition->load(['user', 'meals.items.food']);

        return view('fitapp.admin.nutricion-detalle', ['plan' => $nutrition]);
    }

    public function edit(NutritionPlan $nutrition): View
    {
        $nutrition->load(['user', 'meals.items']);

        $users = User::query()
            ->where('role', 'user')
            ->orderBy('name')
            ->get();
        $selectedUser = $nutrition->user ?: $users->first();

        $excludedFoodIds = collect($selectedUser?->excluded_food_ids ?? [])
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

        $mode = 'edit';
        $plan = $nutrition;

        return view('fitapp.admin.nutricion-crear', compact('catalogs', 'excludedFoods', 'users', 'selectedUser', 'mode', 'plan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'plan_date' => ['nullable', 'date'],
            'goal' => ['nullable', 'string', 'max:120'],
            'meals_per_day' => ['required', 'integer', 'min:1', 'max:8'],
            'target_calories' => ['nullable', 'numeric', 'min:0', 'max:99999'],
            'target_protein' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'target_carbohydrates' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'target_fat' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'daily_water' => ['nullable', 'string', 'max:80'],
            'status' => ['required', 'in:draft,active,archived'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'meals' => ['required', 'array', 'min:1'],
            'meals.*.name' => ['required', 'string', 'max:80'],
            'meals.*.items' => ['nullable', 'array'],
            'meals.*.items.*.food_id' => ['nullable', 'exists:foods,id'],
            'meals.*.items.*.quantity' => ['nullable', 'numeric', 'min:0', 'max:9999'],
        ]);

        $user = User::where('role', 'user')->findOrFail($validated['user_id']);
        $excludedFoodIds = collect($user->excluded_food_ids ?? [])->map(fn ($id): int => (int) $id);

        $plan = DB::transaction(function () use ($validated, $excludedFoodIds) {
            if (($validated['status'] ?? 'draft') === 'active') {
                NutritionPlan::where('user_id', $validated['user_id'])
                    ->where('status', 'active')
                    ->update(['status' => 'archived']);
            }

            $plan = NutritionPlan::create([
                'user_id' => $validated['user_id'],
                'name' => $validated['name'],
                'plan_date' => $validated['plan_date'] ?? now()->toDateString(),
                'goal' => $validated['goal'] ?? null,
                'meals_per_day' => $validated['meals_per_day'],
                'target_calories' => $validated['target_calories'] ?? 0,
                'target_protein' => $validated['target_protein'] ?? 0,
                'target_carbohydrates' => $validated['target_carbohydrates'] ?? 0,
                'target_fat' => $validated['target_fat'] ?? 0,
                'daily_water' => $validated['daily_water'] ?? null,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['meals'] as $mealIndex => $mealData) {
                $meal = $plan->meals()->create([
                    'name' => $mealData['name'],
                    'sort_order' => $mealIndex + 1,
                ]);

                foreach (($mealData['items'] ?? []) as $itemIndex => $itemData) {
                    if (empty($itemData['food_id']) || empty($itemData['quantity'])) {
                        continue;
                    }

                    if ($excludedFoodIds->contains((int) $itemData['food_id'])) {
                        continue;
                    }

                    $food = Food::find($itemData['food_id']);

                    if (! $food) {
                        continue;
                    }

                    $quantity = (float) $itemData['quantity'];
                    $macros = $food->macrosFor($quantity);

                    $meal->items()->create([
                        'food_id' => $food->id,
                        'food_name' => $food->name,
                        'quantity' => $quantity,
                        'unit' => preg_replace('/^[\d.,]+\s*/', '', $food->base_unit) ?: $food->base_unit,
                        'calories' => $macros['calories'],
                        'protein' => $macros['protein'],
                        'carbohydrates' => $macros['carbohydrates'],
                        'fat' => $macros['fat'],
                        'sort_order' => $itemIndex + 1,
                    ]);
                }
            }

            return $plan;
        });

        return redirect()
            ->route('fitapp.admin.nutricion.show', $plan)
            ->with('status', "Plan {$plan->name} guardado correctamente.");
    }

    public function update(Request $request, NutritionPlan $nutrition): RedirectResponse
    {
        $validated = $this->validatedPlanData($request);
        $user = User::where('role', 'user')->findOrFail($validated['user_id']);
        $excludedFoodIds = collect($user->excluded_food_ids ?? [])->map(fn ($id): int => (int) $id);

        DB::transaction(function () use ($nutrition, $validated, $excludedFoodIds) {
            if (($validated['status'] ?? 'draft') === 'active') {
                NutritionPlan::where('user_id', $validated['user_id'])
                    ->where('status', 'active')
                    ->whereKeyNot($nutrition->id)
                    ->update(['status' => 'archived']);
            }

            $nutrition->update([
                'user_id' => $validated['user_id'],
                'name' => $validated['name'],
                'plan_date' => $validated['plan_date'] ?? now()->toDateString(),
                'goal' => $validated['goal'] ?? null,
                'meals_per_day' => $validated['meals_per_day'],
                'target_calories' => $validated['target_calories'] ?? 0,
                'target_protein' => $validated['target_protein'] ?? 0,
                'target_carbohydrates' => $validated['target_carbohydrates'] ?? 0,
                'target_fat' => $validated['target_fat'] ?? 0,
                'daily_water' => $validated['daily_water'] ?? null,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $nutrition->meals()->delete();
            $this->storeMeals($nutrition, $validated['meals'], $excludedFoodIds);
        });

        return redirect()
            ->route('fitapp.admin.nutricion.show', $nutrition)
            ->with('status', "Plan {$nutrition->name} actualizado correctamente.");
    }

    private function validatedPlanData(Request $request): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'plan_date' => ['nullable', 'date'],
            'goal' => ['nullable', 'string', 'max:120'],
            'meals_per_day' => ['required', 'integer', 'min:1', 'max:8'],
            'target_calories' => ['nullable', 'numeric', 'min:0', 'max:99999'],
            'target_protein' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'target_carbohydrates' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'target_fat' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'daily_water' => ['nullable', 'string', 'max:80'],
            'status' => ['required', 'in:draft,active,archived'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'meals' => ['required', 'array', 'min:1'],
            'meals.*.name' => ['required', 'string', 'max:80'],
            'meals.*.items' => ['nullable', 'array'],
            'meals.*.items.*.food_id' => ['nullable', 'exists:foods,id'],
            'meals.*.items.*.quantity' => ['nullable', 'numeric', 'min:0', 'max:9999'],
        ]);
    }

    private function storeMeals(NutritionPlan $plan, array $meals, $excludedFoodIds): void
    {
        foreach ($meals as $mealIndex => $mealData) {
            $meal = $plan->meals()->create([
                'name' => $mealData['name'],
                'sort_order' => $mealIndex + 1,
            ]);

            foreach (($mealData['items'] ?? []) as $itemIndex => $itemData) {
                if (empty($itemData['food_id']) || empty($itemData['quantity'])) {
                    continue;
                }

                if ($excludedFoodIds->contains((int) $itemData['food_id'])) {
                    continue;
                }

                $food = Food::find($itemData['food_id']);

                if (! $food) {
                    continue;
                }

                $quantity = (float) $itemData['quantity'];
                $macros = $food->macrosFor($quantity);

                $meal->items()->create([
                    'food_id' => $food->id,
                    'food_name' => $food->name,
                    'quantity' => $quantity,
                    'unit' => preg_replace('/^[\d.,]+\s*/', '', $food->base_unit) ?: $food->base_unit,
                    'calories' => $macros['calories'],
                    'protein' => $macros['protein'],
                    'carbohydrates' => $macros['carbohydrates'],
                    'fat' => $macros['fat'],
                    'sort_order' => $itemIndex + 1,
                ]);
            }
        }
    }
}
