<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientNutritionController extends Controller
{
    public function daily(Request $request): View
    {
        return view('fitapp.nutricion', [
            'activePlan' => $this->activePlan($request),
        ]);
    }

    public function plan(Request $request): View
    {
        return view('fitapp.plan-alimentario', [
            'activePlan' => $this->activePlan($request),
        ]);
    }

    private function activePlan(Request $request)
    {
        return $request->user()
            ->nutritionPlans()
            ->with('meals.items')
            ->where('status', 'active')
            ->latest()
            ->first();
    }
}
