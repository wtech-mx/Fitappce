<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlanDay;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClientWorkoutController extends Controller
{
    public function syncContext(Request $request): JsonResponse
    {
        return response()->json([
            'user_id' => $request->user()->id,
            'csrf_token' => csrf_token(),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function index(Request $request): View
    {
        $activePlan = $this->activePlan($request);

        return view('fitapp.rutina', [
            'activePlan' => $activePlan,
        ]);
    }

    public function day(Request $request, ?WorkoutPlanDay $day = null): View
    {
        $activePlan = $this->activePlan($request);

        if (! $activePlan) {
            return view('fitapp.rutina-dia', [
                'activePlan' => null,
                'day' => null,
                'blocks' => collect(),
            ]);
        }

        $selectedDay = $day && $day->workout_plan_id === $activePlan->id
            ? $day->loadMissing('exercises.exercise')
            : $activePlan->days->first();

        $progress = $request->user()->workoutSetProgress()
            ->where('workout_plan_day_id', $selectedDay?->id)
            ->whereDate('progress_date', now('America/Mexico_City')->toDateString())
            ->get()
            ->keyBy('progress_key');

        return view('fitapp.rutina-dia', [
            'activePlan' => $activePlan,
            'day' => $selectedDay,
            'blocks' => $selectedDay ? $this->buildBlocks($selectedDay, $progress) : collect(),
        ]);
    }

    public function updateProgress(Request $request, WorkoutPlanDay $day): JsonResponse
    {
        $activePlan = $this->activePlan($request);

        abort_unless($activePlan && $day->workout_plan_id === $activePlan->id, 403);

        $day->loadMissing('exercises.exercise');
        $validated = $request->validate([
            'progress_key' => ['required', 'string', 'max:80'],
            'completed_sets' => ['required', 'integer', 'min:0', 'max:100'],
            'progress_date' => ['nullable', 'date'],
            'rest_started_at' => ['nullable', 'date'],
            'performed_at' => ['nullable', 'date'],
        ]);
        $block = $this->buildBlocks($day, collect())->firstWhere('key', $validated['progress_key']);

        abort_unless($block, 422, 'Bloque de rutina no valido.');

        $today = now('America/Mexico_City')->startOfDay();
        $progressDate = isset($validated['progress_date'])
            ? Carbon::parse($validated['progress_date'], 'America/Mexico_City')->startOfDay()
            : $today->copy();

        abort_if($progressDate->isAfter($today) || $progressDate->lt($today->copy()->subDays(30)), 422, 'La fecha del progreso no es valida.');

        $completedSets = min((int) $validated['completed_sets'], $block['total_sets']);
        $progress = $request->user()->workoutSetProgress()->firstOrNew([
            'workout_plan_day_id' => $day->id,
            'progress_key' => $block['key'],
            'progress_date' => $progressDate->toDateString(),
        ]);
        $previousSets = (int) ($progress->completed_sets ?? 0);
        $performedAt = isset($validated['performed_at'])
            ? Carbon::parse($validated['performed_at'])->min(now())
            : now();
        $progress->completed_sets = $completedSets;
        $progress->completed_at = $completedSets >= $block['total_sets'] ? $performedAt : null;
        $restStartedAt = isset($validated['rest_started_at'])
            ? Carbon::parse($validated['rest_started_at'])->min(now())
            : now();
        $progress->rest_started_at = $completedSets > $previousSets && $completedSets < $block['total_sets']
            ? $restStartedAt
            : null;
        $progress->save();

        $remainingRest = $progress->rest_started_at
            ? max(0, $block['rest_seconds'] - $progress->rest_started_at->diffInSeconds(now()))
            : 0;

        return response()->json([
            'completed_sets' => $completedSets,
            'total_sets' => $block['total_sets'],
            'is_completed' => $completedSets >= $block['total_sets'],
            'rest_seconds' => $remainingRest,
        ]);
    }

    private function activePlan(Request $request)
    {
        return $request->user()
            ->workoutPlans()
            ->with('days.exercises.exercise')
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    private function buildBlocks(WorkoutPlanDay $day, Collection $progress): Collection
    {
        $blocks = collect();

        foreach ($day->exercises as $exercise) {
            $isGroup = in_array($exercise->block_type, ['Biserie', 'Circuito'], true) && filled($exercise->block_group);
            $key = $isGroup
                ? 'group:'.Str::slug($exercise->block_type).':'.$exercise->block_group
                : 'exercise:'.$exercise->id;
            $existing = $blocks->firstWhere('key', $key);

            if (! $existing) {
                $blocks->push([
                    'key' => $key,
                    'type' => $isGroup ? $exercise->block_type : 'Individual',
                    'group' => $isGroup ? $exercise->block_group : null,
                    'exercises' => collect(),
                    'total_sets' => 0,
                    'rest_seconds' => 0,
                    'tone' => ($blocks->count() % 5) + 1,
                ]);
                $existing = $blocks->last();
            }

            $index = $blocks->search(fn ($block) => $block['key'] === $key);
            $existing['exercises']->push($exercise);
            $existing['total_sets'] = max($existing['total_sets'], (int) $this->firstNumber($exercise->sets));

            if ($existing['rest_seconds'] <= 0) {
                $existing['rest_seconds'] = (int) $this->restSeconds($exercise->rest);
            }

            $blocks->put($index, $existing);
        }

        return $blocks->map(function (array $block) use ($progress) {
            $record = $progress->get($block['key']);
            $completedSets = min((int) ($record?->completed_sets ?? 0), $block['total_sets']);
            $remainingSeconds = 0;

            if ($record?->rest_started_at && $completedSets < $block['total_sets']) {
                $elapsed = $record->rest_started_at->diffInSeconds(now());
                $remainingSeconds = max(0, $block['rest_seconds'] - $elapsed);
            }

            return $block + [
                'completed_sets' => $completedSets,
                'is_completed' => $block['total_sets'] > 0 && $completedSets >= $block['total_sets'],
                'remaining_seconds' => $remainingSeconds,
            ];
        });
    }

    private function firstNumber(?string $value): float
    {
        preg_match('/\d+(?:[.,]\d+)?/', (string) $value, $match);

        return isset($match[0]) ? (float) str_replace(',', '.', $match[0]) : 0.0;
    }

    private function restSeconds(?string $value): float
    {
        $seconds = $this->firstNumber($value);

        return preg_match('/min/i', (string) $value) ? $seconds * 60 : $seconds;
    }
}
