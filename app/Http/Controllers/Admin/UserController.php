<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->where('role', 'user')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('goal', 'like', "%{$search}%")
                        ->orWhere('service', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('fitapp.admin.usuarios', compact('users'));
    }

    public function create(): View
    {
        $user = new User([
            'status' => 'active',
            'goal' => 'Aumento de masa muscular',
            'service' => 'Rutina + nutricion',
            'plan_type' => 'Personalizado mensual',
            'training_level' => 'Intermedio',
            'training_days' => 4,
            'training_place' => 'Gimnasio',
            'meals_per_day' => 5,
            'nutrition_restriction' => 'Ninguna',
        ]);
        $mode = 'create';
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

        return view('fitapp.admin.usuarios-alta', compact('catalogs', 'mode', 'user'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedUserData($request);

        $user = User::create([
            ...$validated,
            'role' => 'user',
            'email_verified_at' => now(),
            'excluded_food_ids' => $validated['excluded_food_ids'] ?? [],
            'body_visual_type' => 'avatar',
        ]);

        return redirect()
            ->route('fitapp.admin.usuarios.detalle', $user)
            ->with('status', 'Usuario creado correctamente.');
    }

    public function show(User $user): View
    {
        abort_unless($user->role === 'user', 404);

        $user->load(['measurements' => fn ($query) => $query->latest('measured_at')->latest()]);
        $latestMeasurement = $user->measurements->first();

        return view('fitapp.admin.usuario-detalle', compact('user', 'latestMeasurement'));
    }

    public function edit(User $user): View
    {
        abort_unless($user->role === 'user', 404);

        $mode = 'edit';
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

        return view('fitapp.admin.usuarios-alta', compact('catalogs', 'mode', 'user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'user', 404);

        $validated = $this->validatedUserData($request, $user);
        $user->update([
            ...$validated,
            'excluded_food_ids' => $validated['excluded_food_ids'] ?? [],
        ]);

        return redirect()
            ->route('fitapp.admin.usuarios.detalle', $user)
            ->with('status', 'Usuario actualizado correctamente.');
    }

    private function validatedUserData(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'confirmed', Password::min(8)]
            : ['required', 'confirmed', Password::min(8)];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => $passwordRules,
            'phone' => ['nullable', 'digits:10'],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'gender' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['prospect', 'active', 'appointment_pending', 'paused'])],
            'goal' => ['nullable', 'string', 'max:120'],
            'service' => ['nullable', 'string', 'max:120'],
            'plan_type' => ['nullable', 'string', 'max:120'],
            'training_level' => ['nullable', 'string', 'max:80'],
            'training_days' => ['nullable', 'integer', 'min:1', 'max:7'],
            'training_place' => ['nullable', 'string', 'max:80'],
            'medical_notes' => ['nullable', 'string', 'max:2000'],
            'meals_per_day' => ['nullable', 'integer', 'min:1', 'max:8'],
            'nutrition_restriction' => ['nullable', 'string', 'max:120'],
            'difficult_schedule' => ['nullable', 'string', 'max:80'],
            'excluded_food_ids' => ['nullable', 'array'],
            'excluded_food_ids.*' => ['integer', 'exists:foods,id'],
            'initial_weight' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'initial_body_fat' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'initial_lean_mass' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'initial_waist' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'initial_chest' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'goal_chest' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'initial_hip' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'goal_hip' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'initial_arm' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'goal_arm' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'initial_thigh' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'goal_thigh' => ['nullable', 'numeric', 'min:0', 'max:999'],
        ];

        $validated = $request->validate($rules);

        if ($user && blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        return $validated;
    }
}
