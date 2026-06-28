<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientNutritionController extends Controller
{
    public function daily(Request $request): RedirectResponse
    {
        return redirect()->route('fitapp.plan');
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
