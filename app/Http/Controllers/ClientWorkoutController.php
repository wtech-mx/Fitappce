<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlanDay;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientWorkoutController extends Controller
{
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
            ]);
        }

        $selectedDay = $day && $day->workout_plan_id === $activePlan->id
            ? $day->loadMissing('exercises.exercise')
            : $activePlan->days->first();

        return view('fitapp.rutina-dia', [
            'activePlan' => $activePlan,
            'day' => $selectedDay,
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
}
