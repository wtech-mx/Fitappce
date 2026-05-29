<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientMeasurement;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MeasurementController extends Controller
{
    public function index(Request $request): View
    {
        $measurements = ClientMeasurement::with('user')
            ->when($request->filled('user'), fn ($query) => $query->where('user_id', $request->integer('user')))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->toString();

                $query->whereHas('user', fn ($query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->latest('measured_at')
            ->latest()
            ->get();

        $latest = $measurements->first();

        return view('fitapp.admin.mediciones', compact('measurements', 'latest'));
    }

    public function create(Request $request): View
    {
        $users = User::query()
            ->where('role', 'user')
            ->orderBy('name')
            ->get();
        $selectedUser = $request->filled('user')
            ? $users->firstWhere('id', $request->integer('user'))
            : $users->first();

        return view('fitapp.admin.mediciones-crear', compact('users', 'selectedUser'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', Rule::exists('users', 'id')->where('role', 'user')],
            'measured_at' => ['required', 'date'],
            'appointment_type' => ['required', 'string', 'max:120'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'body_fat' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lean_mass' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'fat_mass' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'waist' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'chest' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'hip' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'arm' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'thigh' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'calf' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'target_body_fat' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'target_weight' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $measurement = ClientMeasurement::create($validated);

        return redirect()
            ->route('fitapp.admin.usuarios.detalle', $measurement->user)
            ->with('status', 'Medicion guardada correctamente.');
    }
}
