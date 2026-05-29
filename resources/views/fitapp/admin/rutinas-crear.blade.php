@extends('layouts.fitapp-admin')

@section('title', ($mode === 'edit' ? 'Editar' : 'Crear').' rutina | FitCoach Admin')

@section('content')
@php
    $planDays = $plan?->days?->values() ?? collect();
    $defaultDays = ['Lunes', 'Martes', 'Miercoles', 'Jueves'];
    $dayCount = max(4, $planDays->count());
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $mode === 'edit' ? 'Editar rutina' : 'Crear rutina' }}</h1>
        <div class="admin-topbar-subtitle">Asigna dias, ejercicios, series, descansos y evidencias.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ $mode === 'edit' && $plan ? route('fitapp.admin.rutinas.detalle', $plan) : route('fitapp.admin.rutinas') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button type="submit" form="workoutPlanForm" class="btn btn-primary-custom px-4">Guardar rutina</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ $mode === 'edit' && $plan ? route('fitapp.admin.rutinas.update', $plan) : route('fitapp.admin.rutinas.store') }}" id="workoutPlanForm">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    <div class="routine-builder-layout">
        <div class="admin-section-stack">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Datos generales</h2>
                    <div class="admin-mini">Cliente, objetivo y estado de la rutina.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Cliente</label>
                            <select name="user_id" class="form-select input-soft" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $plan?->user_id ?? $selectedUser?->id) == $user->id)>{{ $user->name }} - {{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $plan?->name ?? ($selectedUser ? 'Rutina de '.$selectedUser->name : '')) }}" class="form-control input-soft" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Fecha</label>
                            <input type="date" name="plan_date" value="{{ old('plan_date', $plan?->plan_date ?? now()->toDateString()) }}" class="form-control input-soft">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Objetivo</label>
                            <input type="text" name="goal" value="{{ old('goal', $plan?->goal ?? $selectedUser?->goal) }}" class="form-control input-soft" placeholder="Masa muscular">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nivel</label>
                            <input type="text" name="level" value="{{ old('level', $plan?->level ?? $selectedUser?->training_level) }}" class="form-control input-soft" placeholder="Intermedio">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Lugar</label>
                            <input type="text" name="place" value="{{ old('place', $plan?->place ?? $selectedUser?->training_place) }}" class="form-control input-soft" placeholder="Gimnasio">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Dias por semana</label>
                            <input type="number" name="days_per_week" value="{{ old('days_per_week', $plan?->days_per_week ?? ($selectedUser?->training_days ?: 4)) }}" class="form-control input-soft" min="1" max="7" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Duracion</label>
                            <input type="text" name="duration" value="{{ old('duration', $plan?->duration ?? '4 semanas') }}" class="form-control input-soft">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Estado</label>
                            <select name="status" class="form-select input-soft" required>
                                <option value="draft" @selected(old('status', $plan?->status) === 'draft')>Borrador</option>
                                <option value="active" @selected(old('status', $plan?->status ?? 'active') === 'active')>Activo</option>
                                <option value="archived" @selected(old('status', $plan?->status) === 'archived')>Archivado</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Notas generales</label>
                            <textarea name="notes" class="form-control input-soft py-3" rows="3">{{ old('notes', $plan?->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @for($dayIndex = 0; $dayIndex < $dayCount; $dayIndex++)
                @php
                    $day = $planDays->get($dayIndex);
                    $exercises = $day?->exercises?->values() ?? collect();
                    $exerciseCount = max(5, $exercises->count());
                @endphp
                <div class="admin-form-card">
                    <div class="admin-form-card-head">
                        <h2 class="admin-panel-title mb-1">Dia {{ $dayIndex + 1 }}</h2>
                        <div class="admin-mini">Captura ejercicios individuales, biseries o circuitos.</div>
                    </div>
                    <div class="admin-form-card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Dia</label>
                                <input type="text" name="days[{{ $dayIndex }}][day_name]" value="{{ old("days.$dayIndex.day_name", $day?->day_name ?? ($defaultDays[$dayIndex] ?? 'Dia '.($dayIndex + 1))) }}" class="form-control input-soft" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Enfoque</label>
                                <input type="text" name="days[{{ $dayIndex }}][focus]" value="{{ old("days.$dayIndex.focus", $day?->focus) }}" class="form-control input-soft" placeholder="Pierna y gluteo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tiempo estimado</label>
                                <input type="text" name="days[{{ $dayIndex }}][estimated_time]" value="{{ old("days.$dayIndex.estimated_time", $day?->estimated_time) }}" class="form-control input-soft" placeholder="60 min">
                            </div>
                        </div>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Ejercicio</th>
                                        <th>Tipo</th>
                                        <th>Series</th>
                                        <th>Reps</th>
                                        <th>Descanso</th>
                                        <th>Evidencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($exerciseIndex = 0; $exerciseIndex < $exerciseCount; $exerciseIndex++)
                                        @php $exercise = $exercises->get($exerciseIndex); @endphp
                                        <tr>
                                            <td><input type="text" name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][name]" value="{{ old("days.$dayIndex.exercises.$exerciseIndex.name", $exercise?->name) }}" class="form-control input-soft" placeholder="Hip Thrust"></td>
                                            <td>
                                                <select name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][block_type]" class="form-select input-soft">
                                                    @foreach(['Individual', 'Biserie', 'Circuito'] as $type)
                                                        <option value="{{ $type }}" @selected(old("days.$dayIndex.exercises.$exerciseIndex.block_type", $exercise?->block_type ?? 'Individual') === $type)>{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][sets]" value="{{ old("days.$dayIndex.exercises.$exerciseIndex.sets", $exercise?->sets) }}" class="form-control input-soft" placeholder="4"></td>
                                            <td><input type="text" name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][reps]" value="{{ old("days.$dayIndex.exercises.$exerciseIndex.reps", $exercise?->reps) }}" class="form-control input-soft" placeholder="10-12"></td>
                                            <td><input type="text" name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][rest]" value="{{ old("days.$dayIndex.exercises.$exerciseIndex.rest", $exercise?->rest) }}" class="form-control input-soft" placeholder="90 seg"></td>
                                            <td class="text-center">
                                                <input type="checkbox" name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][requires_evidence]" value="1" @checked(old("days.$dayIndex.exercises.$exerciseIndex.requires_evidence", $exercise?->requires_evidence))>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <input type="text" name="days[{{ $dayIndex }}][exercises][{{ $exerciseIndex }}][notes]" value="{{ old("days.$dayIndex.exercises.$exerciseIndex.notes", $exercise?->notes) }}" class="form-control input-soft" placeholder="Indicaciones tecnicas o tempo">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="admin-sticky-col">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Guardar</h2>
                    <div class="admin-mini">Si queda activa, reemplaza la rutina activa anterior del cliente.</div>
                </div>
                <div class="admin-form-card-body">
                    <button type="submit" class="btn btn-primary-custom w-100 mb-2">Guardar rutina</button>
                    <a href="{{ route('fitapp.admin.rutinas') }}" class="btn btn-soft-custom w-100">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
