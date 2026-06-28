<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $appointments = Appointment::query()
            ->with('user')
            ->where('starts_at', '>=', now()->subMonth())
            ->orderBy('starts_at')
            ->get();

        $users = User::query()
            ->where('role', 'user')
            ->orderBy('name')
            ->get();

        $todayAppointments = $appointments
            ->filter(fn (Appointment $appointment): bool => $appointment->starts_at->isSameDay(now()))
            ->values();

        return view('fitapp.admin.citas-dinamico', compact('appointments', 'users', 'todayAppointments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', Rule::exists('users', 'id')->where('role', 'user')],
            'appointment_type' => ['required', 'string', 'max:120'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'modality' => ['required', Rule::in(['Presencial', 'Online'])],
            'payment_method' => ['nullable', 'string', 'max:80'],
            'status' => ['required', Rule::in(['scheduled', 'confirmed', 'in_progress'])],
            'location' => ['nullable', 'string', 'max:180'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'redirect_to' => ['nullable', 'string'],
        ]);

        $user = User::query()->where('role', 'user')->findOrFail($validated['user_id']);
        [$startsAt, $endsAt] = $this->appointmentRange($validated);

        $this->ensureAvailable($startsAt, $endsAt);

        Appointment::create([
            'user_id' => $user->id,
            'created_by' => $request->user()?->id,
            'kind' => 'appointment',
            'title' => $validated['appointment_type'].' - '.$user->name,
            'appointment_type' => $validated['appointment_type'],
            'modality' => $validated['modality'],
            'payment_method' => $validated['payment_method'] ?? null,
            'status' => $validated['status'],
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'duration_minutes' => $validated['duration_minutes'],
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect($validated['redirect_to'] ?: route('fitapp.admin.citas'))
            ->with('status', 'Cita agendada correctamente.');
    }

    public function block(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'appointment_date' => ['required', 'date'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'redirect_to' => ['nullable', 'string'],
        ]);

        $startsAt = Carbon::parse($validated['appointment_date'].' '.$validated['starts_at']);
        $endsAt = Carbon::parse($validated['appointment_date'].' '.$validated['ends_at']);
        $this->ensureAvailable($startsAt, $endsAt);

        Appointment::create([
            'created_by' => $request->user()?->id,
            'kind' => 'block',
            'title' => $validated['title'],
            'appointment_type' => 'Horario bloqueado',
            'modality' => 'Presencial',
            'status' => 'blocked',
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'duration_minutes' => $startsAt->diffInMinutes($endsAt),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect($validated['redirect_to'] ?: route('fitapp.admin.citas'))
            ->with('status', 'Horario bloqueado correctamente.');
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        abort_unless($appointment->kind === 'appointment', 404);

        $validated = $request->validate([
            'appointment_type' => ['required', 'string', 'max:120'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'modality' => ['required', Rule::in(['Presencial', 'Online'])],
            'payment_method' => ['nullable', 'string', 'max:80'],
            'status' => ['required', Rule::in(['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled'])],
            'location' => ['nullable', 'string', 'max:180'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'redirect_to' => ['nullable', 'string'],
        ]);

        [$startsAt, $endsAt] = $this->appointmentRange($validated);
        $this->ensureAvailable($startsAt, $endsAt, $appointment->id);

        $appointment->update([
            'title' => $validated['appointment_type'].' - '.$appointment->user?->name,
            'appointment_type' => $validated['appointment_type'],
            'modality' => $validated['modality'],
            'payment_method' => $validated['payment_method'] ?? null,
            'status' => $validated['status'],
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'duration_minutes' => $validated['duration_minutes'],
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect($validated['redirect_to'] ?: route('fitapp.admin.citas'))
            ->with('status', 'Cita reagendada correctamente.');
    }


    private function appointmentRange(array $validated): array
    {
        $startsAt = Carbon::parse($validated['appointment_date'].' '.$validated['appointment_time']);
        $endsAt = $startsAt->copy()->addMinutes((int) $validated['duration_minutes']);

        return [$startsAt, $endsAt];
    }

    private function ensureAvailable(Carbon $startsAt, Carbon $endsAt, ?int $ignoreId = null): void
    {
        $hasConflict = Appointment::query()
            ->overlapping($startsAt->toDateTimeString(), $endsAt->toDateTimeString(), $ignoreId)
            ->exists();

        if ($hasConflict) {
            throw ValidationException::withMessages([
                'appointment_time' => 'Ese horario se empalma con otra cita o con un bloqueo.',
            ]);
        }
    }
}
