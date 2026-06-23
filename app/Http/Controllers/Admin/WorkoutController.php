<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
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
        $plans = WorkoutPlan::with(['user', 'days.exercises.exercise'])
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

        $exerciseCatalog = Exercise::where('is_active', true)->orderBy('name')->get();

        return view('fitapp.admin.rutinas-crear', compact('users', 'selectedUser', 'mode', 'plan', 'exerciseCatalog'));
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
        $routine->load(['user', 'days.exercises.exercise']);

        return view('fitapp.admin.rutina-detalle', ['plan' => $routine]);
    }

    public function edit(WorkoutPlan $routine): View
    {
        $routine->load(['days.exercises.exercise']);
        $users = User::where('role', 'user')->orderBy('name')->get();
        $selectedUser = $routine->user ?: $users->first();
        $mode = 'edit';
        $plan = $routine;

        $exerciseCatalog = Exercise::where('is_active', true)->orderBy('name')->get();

        return view('fitapp.admin.rutinas-crear', compact('users', 'selectedUser', 'mode', 'plan', 'exerciseCatalog'));
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
            'days.*.exercises.*.exercise_id' => ['nullable', 'exists:exercises,id'],
            'days.*.exercises.*.name' => ['nullable', 'string', 'max:160'],
            'days.*.exercises.*.block_type' => ['nullable', 'string', 'max:80'],
            'days.*.exercises.*.block_group' => ['nullable', 'string', 'max:20'],
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
        $exerciseIds = collect($days)
            ->flatMap(fn ($day) => collect($day['exercises'] ?? [])->pluck('exercise_id'))
            ->filter()
            ->unique()
            ->values();
        $catalog = Exercise::whereIn('id', $exerciseIds)->get()->keyBy('id');

        foreach ($days as $dayIndex => $dayData) {
            $estimatedTime = $this->estimatedTime($dayData['exercises'] ?? []);
            $day = $plan->days()->create([
                'day_name' => $dayData['day_name'],
                'focus' => $dayData['focus'] ?? null,
                'estimated_time' => $estimatedTime ?: ($dayData['estimated_time'] ?? null),
                'sort_order' => $dayIndex + 1,
            ]);

            foreach (($dayData['exercises'] ?? []) as $exerciseIndex => $exerciseData) {
                $catalogExercise = filled($exerciseData['exercise_id'] ?? null)
                    ? $catalog->get((int) $exerciseData['exercise_id'])
                    : null;
                $exerciseName = $catalogExercise?->name ?? ($exerciseData['name'] ?? null);

                if (blank($exerciseName)) {
                    continue;
                }

                $day->exercises()->create([
                    'exercise_id' => $catalogExercise?->id,
                    'name' => $exerciseName,
                    'block_type' => $exerciseData['block_type'] ?? 'Individual',
                    'block_group' => ($exerciseData['block_type'] ?? 'Individual') === 'Individual'
                        ? null
                        : ($exerciseData['block_group'] ?? null),
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

    private function estimatedTime(array $exercises): ?string
    {
        $totalSeconds = 0.0;
        $groups = [];

        foreach ($exercises as $index => $exercise) {
            if (blank($exercise['exercise_id'] ?? null) && blank($exercise['name'] ?? null)) {
                continue;
            }

            $sets = $this->firstNumber($exercise['sets'] ?? null);
            $reps = $this->averageRange($exercise['reps'] ?? null);

            if ($sets <= 0 || $reps <= 0) {
                continue;
            }
            $restSeconds = $this->restSeconds($exercise['rest'] ?? null);
            $workSeconds = $sets * $reps * 40;
            $type = $exercise['block_type'] ?? 'Individual';
            $group = $exercise['block_group'] ?? null;

            if ($type === 'Individual' || blank($group)) {
                $totalSeconds += $workSeconds + (max(0, $sets - 1) * $restSeconds);
                continue;
            }

            $key = $type.'|'.$group;
            $groups[$key] ??= ['work' => 0.0, 'sets' => 0.0, 'rest' => 0.0, 'order' => $index];
            $groups[$key]['work'] += $workSeconds;
            $groups[$key]['sets'] = max($groups[$key]['sets'], $sets);

            if ($groups[$key]['rest'] <= 0 && $restSeconds > 0) {
                $groups[$key]['rest'] = $restSeconds;
            }
        }

        foreach ($groups as $group) {
            $totalSeconds += $group['work'] + (max(0, $group['sets'] - 1) * $group['rest']);
        }

        if ($totalSeconds <= 0) {
            return null;
        }

        $minutes = (int) ceil($totalSeconds / 60);

        return $minutes >= 60
            ? intdiv($minutes, 60).' h '.str_pad((string) ($minutes % 60), 2, '0', STR_PAD_LEFT).' min'
            : $minutes.' min';
    }

    private function firstNumber(?string $value): float
    {
        preg_match('/\d+(?:[.,]\d+)?/', (string) $value, $match);

        return isset($match[0]) ? (float) str_replace(',', '.', $match[0]) : 0.0;
    }

    private function averageRange(?string $value): float
    {
        preg_match_all('/\d+(?:[.,]\d+)?/', (string) $value, $matches);
        $numbers = collect($matches[0] ?? [])->map(fn ($number) => (float) str_replace(',', '.', $number));

        if ($numbers->count() >= 2 && preg_match('/[-–]|\s+a\s+/i', (string) $value)) {
            return ($numbers[0] + $numbers[1]) / 2;
        }

        return (float) ($numbers->first() ?? 0);
    }

    private function restSeconds(?string $value): float
    {
        $seconds = $this->firstNumber($value);

        return preg_match('/min/i', (string) $value) ? $seconds * 60 : $seconds;
    }
}
