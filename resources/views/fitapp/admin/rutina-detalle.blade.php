@extends('layouts.fitapp-admin')

@section('title', 'Detalle de rutina | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $plan->name }}</h1>
        <div class="admin-topbar-subtitle">{{ $plan->user?->name ?: 'Sin usuario' }} - {{ $plan->plan_date ?: 'Sin fecha' }}</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.rutinas') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.admin.rutinas.edit', $plan) }}" class="btn btn-primary-custom px-4">Editar rutina</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Resumen del plan</h2>
                <span class="admin-tag {{ $plan->status === 'active' ? 'blue' : 'yellow' }}">{{ $plan->status === 'active' ? 'Activo' : ($plan->status === 'archived' ? 'Archivado' : 'Borrador') }}</span>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-summary-grid">
                    <div><span>Objetivo</span><strong>{{ $plan->goal ?: '-' }}</strong></div>
                    <div><span>Nivel</span><strong>{{ $plan->level ?: '-' }}</strong></div>
                    <div><span>Duracion</span><strong>{{ $plan->duration ?: '-' }}</strong></div>
                    <div><span>Lugar</span><strong>{{ $plan->place ?: '-' }}</strong></div>
                </div>
                <div class="routine-note mt-3">{{ $plan->notes ?: 'Sin indicaciones generales.' }}</div>
            </div>
        </div>

        @foreach($plan->days as $day)
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div>
                        <h2 class="admin-panel-title mb-1">{{ $day->day_name }} - {{ $day->focus ?: 'General' }}</h2>
                        <div class="admin-mini">Tiempo estimado: {{ $day->estimated_time ?: '-' }}</div>
                    </div>
                    <span class="admin-tag blue">{{ $day->exercises->count() }} ejercicios</span>
                </div>
                <div class="admin-form-card-body">
                    @if($day->exercises->isEmpty())
                        <div class="admin-helper-note mb-0">Este dia no tiene ejercicios capturados.</div>
                    @else
                        <div class="routine-table-wrap">
                            <table class="routine-table">
                                <thead>
                                    <tr>
                                        <th>Orden</th>
                                        <th>Ejercicio</th>
                                        <th>Tipo</th>
                                        <th>Series / reps</th>
                                        <th>Descanso</th>
                                        <th>Evidencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($day->exercises as $exercise)
                                        <tr>
                                            <td><span class="routine-order compact">{{ $loop->iteration }}</span></td>
                                            <td>
                                                <div class="fw-bold">{{ $exercise->name }}</div>
                                                <div class="admin-mini">{{ $exercise->notes ?: 'Sin notas.' }}</div>
                                            </td>
                                            <td>
                                                <span class="admin-tag {{ $exercise->block_type === 'Biserie' ? 'yellow' : ($exercise->block_type === 'Circuito' ? 'blue' : '') }}">{{ $exercise->block_type }}</span>
                                                @if($exercise->block_group)
                                                    <div class="admin-mini mt-1">Grupo {{ $exercise->block_group }}</div>
                                                @endif
                                            </td>
                                            <td>{{ trim(($exercise->sets ?: '-').' x '.($exercise->reps ?: '-')) }}</td>
                                            <td>{{ $exercise->rest ?: '-' }}</td>
                                            <td>
                                                @if($exercise->requires_evidence)
                                                    <span class="admin-tag blue">Video</span>
                                                @else
                                                    <span class="admin-tag">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Control de rutina</h2>
                <div class="admin-mini">Uso administrativo</div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card"><div class="value">{{ $plan->days->count() }}</div><div class="label">Dias</div></div>
                    <div class="admin-stat-inline-card"><div class="value">{{ $plan->exerciseCount() }}</div><div class="label">Ejercicios</div></div>
                </div>
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card"><div class="value">{{ $plan->evidenceCount() }}</div><div class="label">Evidencias</div></div>
                    <div class="admin-stat-inline-card"><div class="value">{{ $plan->days_per_week }}</div><div class="label">Dias/sem</div></div>
                </div>
                @if($plan->user)
                    <a href="{{ route('fitapp.admin.usuarios.detalle', $plan->user) }}" class="btn btn-soft-custom w-100">Ver usuario</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
