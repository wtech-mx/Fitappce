<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
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

        $user->load([
            'measurements' => fn ($query) => $query->latest('measured_at')->latest(),
            'nutritionPlans' => fn ($query) => $query
                ->with('meals.items')
                ->where('status', 'active')
                ->latest('plan_date')
                ->latest(),
            'workoutPlans' => fn ($query) => $query
                ->with('days.exercises')
                ->where('status', 'active')
                ->latest('plan_date')
                ->latest(),
        ]);
        $latestMeasurement = $user->measurements->first();
        $activeNutritionPlan = $user->nutritionPlans->first();
        $activeWorkoutPlan = $user->workoutPlans->first();

        return view('fitapp.admin.usuario-detalle', compact('user', 'latestMeasurement', 'activeNutritionPlan', 'activeWorkoutPlan'));
    }

    public function record(User $user): View
    {
        abort_unless($user->role === 'user', 404);

        $user->load([
            'measurements' => fn ($query) => $query->latest('measured_at')->latest(),
            'nutritionPlans' => fn ($query) => $query
                ->with('meals.items')
                ->latest('plan_date')
                ->latest(),
            'workoutPlans' => fn ($query) => $query
                ->with('days.exercises')
                ->latest('plan_date')
                ->latest(),
            'appointments' => fn ($query) => $query
                ->latest('starts_at')
                ->latest(),
            'progressPhotos' => fn ($query) => $query
                ->with('appointment')
                ->latest(),
        ]);

        $latestMeasurement = $user->measurements->first();
        $activeNutritionPlan = $user->nutritionPlans->firstWhere('status', 'active') ?? $user->nutritionPlans->first();
        $activeWorkoutPlan = $user->workoutPlans->firstWhere('status', 'active') ?? $user->workoutPlans->first();
        $nutritionTotals = $activeNutritionPlan?->macroTotals();
        $nextFollowUp = $this->nextFollowUpDate($user);
        $suggestedSlots = $this->suggestedAppointmentSlots($nextFollowUp);
        $appointmentDateEvents = $this->appointmentDateEvents();
        $blockedDates = $this->blockedAppointmentDates();

        return view('fitapp.admin.usuario-expediente-dinamico', compact(
            'user',
            'latestMeasurement',
            'activeNutritionPlan',
            'activeWorkoutPlan',
            'nutritionTotals',
            'nextFollowUp',
            'suggestedSlots',
            'appointmentDateEvents',
            'blockedDates',
        ));
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

    private function nextFollowUpDate(User $user): Carbon
    {
        $lastAppointment = $user->appointments
            ->where('kind', 'appointment')
            ->whereNotIn('status', ['cancelled'])
            ->sortByDesc('starts_at')
            ->first();

        $baseDate = $lastAppointment?->starts_at ?: now();

        return $baseDate->copy()->addMonth()->next(Carbon::WEDNESDAY);
    }

    private function suggestedAppointmentSlots(Carbon $date): array
    {
        $candidates = collect([
            ['date' => $date->copy(), 'time' => '10:00'],
            ['date' => $date->copy(), 'time' => '12:30'],
            ['date' => $date->copy()->addDay(), 'time' => '10:00'],
            ['date' => $date->copy()->addDay(), 'time' => '16:00'],
        ]);

        return $candidates->map(function (array $candidate): array {
            $startsAt = Carbon::parse($candidate['date']->toDateString().' '.$candidate['time']);
            $endsAt = $startsAt->copy()->addMinutes(45);
            $conflict = Appointment::query()
                ->overlapping($startsAt->toDateTimeString(), $endsAt->toDateTimeString())
                ->first();

            return [
                'date' => $startsAt->toDateString(),
                'display_date' => $startsAt->translatedFormat('d M'),
                'time' => $startsAt->format('H:i'),
                'display_time' => $startsAt->format('h:i A'),
                'status' => $conflict ? ($conflict->kind === 'block' ? 'Bloqueado' : 'Ocupado') : 'Disponible',
                'available' => ! $conflict,
            ];
        })->all();
    }

    private function appointmentDateEvents(): array
    {
        return Appointment::query()
            ->with('user')
            ->where('starts_at', '>=', now()->subMonth())
            ->where('starts_at', '<=', now()->addMonths(6))
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn (Appointment $appointment): string => $appointment->starts_at->toDateString())
            ->map(fn ($appointments) => $appointments->map(fn (Appointment $appointment): array => [
                'kind' => $appointment->kind,
                'time' => $appointment->starts_at->format('h:i A').' - '.$appointment->ends_at->format('h:i A'),
                'title' => $appointment->kind === 'block'
                    ? $appointment->title
                    : ($appointment->user?->name ?: $appointment->title),
                'detail' => $appointment->appointment_type ?: 'Horario bloqueado',
                'status' => $appointment->statusLabel(),
            ])->values()->all())
            ->all();
    }

    private function blockedAppointmentDates(): array
    {
        return Appointment::query()
            ->blocks()
            ->where('starts_at', '>=', now()->subMonth())
            ->where('starts_at', '<=', now()->addMonths(6))
            ->where('status', 'blocked')
            ->get()
            ->filter(fn (Appointment $appointment): bool => $appointment->starts_at->diffInMinutes($appointment->ends_at) >= 480)
            ->map(fn (Appointment $appointment): string => $appointment->starts_at->toDateString())
            ->unique()
            ->values()
            ->all();
    }
}
