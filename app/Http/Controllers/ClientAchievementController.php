<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientAchievementController extends Controller
{
    public function index(Request $request): View
    {
        $userAchievements = $request->user()
            ->clientAchievements()
            ->with('achievement')
            ->get()
            ->keyBy('achievement_id');

        $achievements = Achievement::where('is_active', true)
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        return view('fitapp.logros', compact('achievements', 'userAchievements'));
    }
}
