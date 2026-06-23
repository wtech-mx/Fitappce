<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClientDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $workout = $user->workoutPlans()
            ->with('days.exercises.exercise')
            ->where('status', 'active')
            ->latest()
            ->first();
        $nutrition = $user->nutritionPlans()
            ->with('meals.items')
            ->where('status', 'active')
            ->latest()
            ->first();
        $latestMeasurement = $user->measurements()
            ->latest('measured_at')
            ->latest()
            ->first();
        $localNow = now('America/Mexico_City');

        $todayName = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miercoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sabado',
            7 => 'Domingo',
        ][$localNow->dayOfWeekIso];

        $todayWorkoutDay = $workout?->days->first(
            fn ($day) => $this->normalizeDay($day->day_name) === $this->normalizeDay($todayName)
        ) ?? $workout?->days->first();

        $weekTotal = $this->weekTotal($workout?->duration);
        $currentWeek = $this->currentWeek($workout?->plan_date, $weekTotal, $localNow);
        $nutritionTotals = $nutrition?->macroTotals();
        $nutritionCalories = (float) ($nutritionTotals['calories'] ?? 0);

        if ($nutritionCalories <= 0) {
            $nutritionCalories = (float) ($nutrition?->target_calories ?? 0);
        }

        return view('fitapp.dashboard-dinamico', [
            'user' => $user,
            'workout' => $workout,
            'nutrition' => $nutrition,
            'latestMeasurement' => $latestMeasurement,
            'todayWorkoutDay' => $todayWorkoutDay,
            'todayName' => $todayName,
            'currentWeek' => $currentWeek,
            'weekTotal' => $weekTotal,
            'nutritionCalories' => $nutritionCalories,
            'measurementCount' => $user->measurements()->count(),
        ]);
    }

    private function normalizeDay(?string $day): string
    {
        return Str::lower(Str::ascii(trim((string) $day)));
    }

    private function weekTotal(?string $duration): int
    {
        preg_match('/(\d+)/', (string) $duration, $matches);

        return max(1, min(12, (int) ($matches[1] ?? 4)));
    }

    private function currentWeek(?string $planDate, int $weekTotal, Carbon $localNow): int
    {
        if (! $planDate) {
            return 1;
        }

        $start = Carbon::parse($planDate, 'America/Mexico_City')->startOfDay();
        $week = $start->greaterThan($localNow) ? 1 : $start->diffInWeeks($localNow->copy()->startOfDay()) + 1;

        return max(1, min($weekTotal, $week));
    }
}
