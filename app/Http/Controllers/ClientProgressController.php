<?php

namespace App\Http\Controllers;

use App\Models\ClientMeasurement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientProgressController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $measurements = $this->measurements($user);
        $latest = $measurements->first();
        $previous = $measurements->skip(1)->first();

        return view('fitapp.progreso', [
            'user' => $user,
            'measurements' => $measurements,
            'latestMeasurement' => $latest,
            'previousMeasurement' => $previous,
            'display' => $this->displayData($user, $latest, $previous),
            'bodyVisualType' => $user->body_visual_type ?? 'avatar',
        ]);
    }

    public function report(Request $request): View
    {
        $user = $request->user();
        $measurements = $this->measurements($user);
        $latest = $measurements->first();
        $previous = $measurements->skip(1)->first();

        return view('fitapp.progreso-corporal', [
            'user' => $user,
            'measurements' => $measurements,
            'latestMeasurement' => $latest,
            'previousMeasurement' => $previous,
            'display' => $this->displayData($user, $latest, $previous),
            'bodyVisualType' => $user->body_visual_type ?? 'avatar',
        ]);
    }

    private function measurements(User $user)
    {
        return $user->measurements()
            ->latest('measured_at')
            ->latest()
            ->get();
    }

    private function displayData(User $user, ?ClientMeasurement $latest, ?ClientMeasurement $previous): array
    {
        $current = [
            'weight' => $latest?->weight ?? $user->initial_weight,
            'body_fat' => $latest?->body_fat ?? $user->initial_body_fat,
            'lean_mass' => $latest?->lean_mass ?? $user->initial_lean_mass,
            'fat_mass' => $latest?->fat_mass,
            'waist' => $latest?->waist ?? $user->initial_waist,
            'chest' => $latest?->chest ?? $user->initial_chest,
            'hip' => $latest?->hip ?? $user->initial_hip,
            'arm' => $latest?->arm ?? $user->initial_arm,
            'thigh' => $latest?->thigh ?? $user->initial_thigh,
            'calf' => $latest?->calf,
        ];

        $before = [
            'weight' => $previous?->weight,
            'body_fat' => $previous?->body_fat,
            'lean_mass' => $previous?->lean_mass,
            'fat_mass' => $previous?->fat_mass,
            'waist' => $previous?->waist,
            'chest' => $previous?->chest,
            'hip' => $previous?->hip,
            'arm' => $previous?->arm,
            'thigh' => $previous?->thigh,
            'calf' => $previous?->calf,
        ];

        if (! $current['fat_mass'] && $current['weight'] && $current['body_fat']) {
            $current['fat_mass'] = round(((float) $current['weight'] * (float) $current['body_fat']) / 100, 2);
        }

        return [
            'current' => $current,
            'before' => $before,
            'latest_date' => $latest?->measured_at,
            'has_measurements' => (bool) $latest,
        ];
    }
}
