<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NutritionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(Request $request): View
    {
        $selectedUser = $request->filled('user')
            ? User::where('role', 'user')->find($request->integer('user'))
            : null;
        $tab = $request->string('tab', 'active')->toString();

        $baseQuery = NutritionPlan::with(['user', 'meals.items'])
            ->when($selectedUser, fn ($query) => $query->where('user_id', $selectedUser->id))
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
            });

        $plans = (clone $baseQuery)
            ->when($tab === 'active', fn ($query) => $query->where('status', 'active'))
            ->when($tab === 'past', fn ($query) => $query->where('status', 'archived'))
            ->when($tab === 'favorites', fn ($query) => $query->where('preference', 'favorite'))
            ->when($tab === 'least_favorites', fn ($query) => $query->where('preference', 'least_favorite'))
            ->latest()
            ->get();

        $stats = [
            'active' => (clone $baseQuery)->where('status', 'active')->count(),
            'past' => (clone $baseQuery)->where('status', 'archived')->count(),
            'favorites' => (clone $baseQuery)->where('preference', 'favorite')->count(),
            'least_favorites' => (clone $baseQuery)->where('preference', 'least_favorite')->count(),
        ];

        return view('fitapp.admin.planes', compact('plans', 'selectedUser', 'tab', 'stats'));
    }
}
