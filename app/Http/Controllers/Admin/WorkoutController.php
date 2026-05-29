<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WorkoutController extends Controller
{
    public function index(Request $request): View
    {
        $plans = WorkoutPlan::with(['user', 'days.exercises'])
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

        return view('fitapp.admin.rutinas', compact('plans'));
    }

    public function create(Request $request): View
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $selectedUser = $request->filled('user')
            ? $users->firstWhere('id', $request->integer('user'))
            : $users->first();
        $mode = 'create';
        $plan = null;

        return view('fitapp.admin.rutinas-crear', compact('users', 'selectedUser', 'mode', 'plan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedPlanData($request);

        $plan = DB::transaction(function () use ($validated) {
            if (($validated['status'] ?? 'draft') === 'active') {
                WorkoutPlan::where('user_id', $validated['user_id'])
                    ->where('status', 'active')
                    ->update(['status' => 'archived']);
            }

            $plan = WorkoutPlan::create($this->planPayload($validated));
            $this->storeDays($plan, $validated['days']);

            return $plan;
        });

        return redirect()
            ->route('fitapp.admin.rutinas.detalle', $plan)
            ->with('status', "Rutina {$plan->name} guardada correctamente.");
    }

    public function show(WorkoutPlan $routine): View
    {
        $routine->load(['user', 'days.exercises']);

        return view('fitapp.admin.rutina-detalle', ['plan' => $routine]);
    }

    public function edit(WorkoutPlan $routine): View
    {
        $routine->load(['days.exercises']);
        $users = User::where('role', 'user')->orderBy('name')->get();
        $selectedUser = $routine->user ?: $users->first();
        $mode = 'edit';
        $plan = $routine;

        return view('fitapp.admin.rutinas-crear', compact('users', 'selectedUser', 'mode', 'plan'));
    }

    public function update(Request $request, WorkoutPlan $routine): RedirectResponse
    {
        $validated = $this->validatedPlanData($request);

        DB::transaction(function () use ($routine, $validated) {
            if (($validated['status'] ?? 'draft') === 'active') {
                WorkoutPlan::where('user_id', $validated['user_id'])
                    ->where('status', 'active')
                    ->whereKeyNot($routine->id)
                    ->update(['status' => 'archived']);
            }

            $routine->update($this->planPayload($validated));
            $routine->days()->delete();
            $this->storeDays($routine, $validated['days']);
        });

        return redirect()
            ->route('fitapp.admin.rutinas.detalle', $routine)
            ->with('status', "Rutina {$routine->name} actualizada correctamente.");
    }

    private function validatedPlanData(Request $request): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'plan_date' => ['nullable', 'date'],
            'goal' => ['nullable', 'string', 'max:120'],
            'level' => ['nullable', 'string', 'max:80'],
            'place' => ['nullable', 'string', 'max:80'],
            'days_per_week' => ['required', 'integer', 'min:1', 'max:7'],
            'duration' => ['nullable', 'string', 'max:80'],
            'status' => ['required', 'in:draft,active,archived'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'days' => ['required', 'array', 'min:1'],
            'days.*.day_name' => ['required', 'string', 'max:80'],
            'days.*.focus' => ['nullable', 'string', 'max:120'],
            'days.*.estimated_time' => ['nullable', 'string', 'max:80'],
            'days.*.exercises' => ['nullable', 'array'],
            'days.*.exercises.*.name' => ['nullable', 'string', 'max:160'],
            'days.*.exercises.*.block_type' => ['nullable', 'string', 'max:80'],
            'days.*.exercises.*.sets' => ['nullable', 'string', 'max:40'],
            'days.*.exercises.*.reps' => ['nullable', 'string', 'max:80'],
            'days.*.exercises.*.rest' => ['nullable', 'string', 'max:80'],
            'days.*.exercises.*.tempo' => ['nullable', 'string', 'max:80'],
            'days.*.exercises.*.requires_evidence' => ['nullable', 'boolean'],
            'days.*.exercises.*.notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function planPayload(array $validated): array
    {
        return [
            'user_id' => $validated['user_id'],
            'name' => $validated['name'],
            'plan_date' => $validated['plan_date'] ?? now()->toDateString(),
            'goal' => $validated['goal'] ?? null,
            'level' => $validated['level'] ?? null,
            'place' => $validated['place'] ?? null,
            'days_per_week' => $validated['days_per_week'],
            'duration' => $validated['duration'] ?? null,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ];
    }

    private function storeDays(WorkoutPlan $plan, array $days): void
    {
        foreach ($days as $dayIndex => $dayData) {
            $day = $plan->days()->create([
                'day_name' => $dayData['day_name'],
                'focus' => $dayData['focus'] ?? null,
                'estimated_time' => $dayData['estimated_time'] ?? null,
                'sort_order' => $dayIndex + 1,
            ]);

            foreach (($dayData['exercises'] ?? []) as $exerciseIndex => $exerciseData) {
                if (blank($exerciseData['name'] ?? null)) {
                    continue;
                }

                $day->exercises()->create([
                    'name' => $exerciseData['name'],
                    'block_type' => $exerciseData['block_type'] ?? 'Individual',
                    'sets' => $exerciseData['sets'] ?? null,
                    'reps' => $exerciseData['reps'] ?? null,
                    'rest' => $exerciseData['rest'] ?? null,
                    'tempo' => $exerciseData['tempo'] ?? null,
                    'requires_evidence' => (bool) ($exerciseData['requires_evidence'] ?? false),
                    'notes' => $exerciseData['notes'] ?? null,
                    'sort_order' => $exerciseIndex + 1,
                ]);
            }
        }
    }
}
