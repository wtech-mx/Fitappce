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
        $nextAppointment = $user->appointments()
            ->where('kind', 'appointment')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->first();
        $photoUploadWindow = $this->photoUploadWindow($nextAppointment);
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
        $filledNutritionMeals = $nutrition?->meals
            ->filter(fn ($meal) => $meal->items->isNotEmpty())
            ->values() ?? collect();
        $nutritionTotals = $filledNutritionMeals->flatMap(fn ($meal) => $meal->items)->reduce(
            fn ($totals, $item) => [
                'calories' => $totals['calories'] + (float) $item->calories,
                'protein' => $totals['protein'] + (float) $item->protein,
            ],
            ['calories' => 0, 'protein' => 0]
        );
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
            'nutritionMealCount' => $filledNutritionMeals->count(),
            'measurementCount' => $user->measurements()->count(),
            'nextAppointment' => $nextAppointment,
            'photoUploadWindow' => $photoUploadWindow,
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

    private function photoUploadWindow($appointment): array
    {
        if (! $appointment) {
            return ['is_open' => false, 'label' => 'Sin cita'];
        }

        $startsAt = $appointment->starts_at->copy()->subDays(7)->startOfDay();
        $endsAt = $appointment->starts_at->copy()->endOfDay();
        $now = now();

        return [
            'is_open' => $now->greaterThanOrEqualTo($startsAt) && $now->lessThanOrEqualTo($endsAt),
            'label' => $now->lt($startsAt) ? 'Abre '.$startsAt->format('d/m') : 'Subir ahora',
        ];
    }
}
