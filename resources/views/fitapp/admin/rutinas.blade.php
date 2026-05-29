@extends('layouts.fitapp-admin')

@section('title', 'Rutinas | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Rutinas</h1>
        <div class="admin-topbar-subtitle">Planes de entrenamiento reales por cliente.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="btn btn-primary-custom px-4">Nueva rutina</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Rutinas activas</div>
        <div class="admin-stat-value">{{ $plans->where('status', 'active')->count() }}</div>
        <div class="admin-stat-note">Asignadas a clientes</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Total rutinas</div>
        <div class="admin-stat-value">{{ $plans->count() }}</div>
        <div class="admin-stat-note">Historial de entrenamiento</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Ejercicios</div>
        <div class="admin-stat-value">{{ $plans->sum(fn ($plan) => $plan->exerciseCount()) }}</div>
        <div class="admin-stat-note">Bloques capturados</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Evidencias</div>
        <div class="admin-stat-value">{{ $plans->sum(fn ($plan) => $plan->evidenceCount()) }}</div>
        <div class="admin-stat-note">Videos requeridos</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todas</span>
    <form method="GET" action="{{ route('fitapp.admin.rutinas') }}" class="ms-auto admin-search">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar rutina, usuario u objetivo...">
    </form>
</div>

@if($plans->isEmpty())
    <div class="admin-helper-note">
        <div class="fw-bold mb-1">Sin rutinas capturadas</div>
        <div class="admin-mini mb-3">Crea la primera rutina para asignarla al usuario.</div>
        <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="btn btn-primary-custom">Nueva rutina</a>
    </div>
@else
    <div class="admin-card-grid">
        @foreach($plans as $plan)
            <div class="admin-routine-card">
                <div class="admin-card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div>
                            <div class="admin-card-title">{{ $plan->name }}</div>
                            <div class="admin-card-text">
                                {{ $plan->user?->name ?: 'Sin usuario' }} - {{ $plan->plan_date ?: 'Sin fecha' }}
                            </div>
                        </div>
                        <span class="admin-tag {{ $plan->status === 'active' ? 'blue' : 'yellow' }}">{{ $plan->status === 'active' ? 'Activo' : ($plan->status === 'archived' ? 'Archivado' : 'Borrador') }}</span>
                    </div>

                    <div class="routine-purpose-box mb-3">
                        <div class="admin-mini mb-1">Proposito</div>
                        <div class="fw-bold">{{ $plan->goal ?: 'Sin objetivo capturado' }}</div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($plan->days as $day)
                            <span class="admin-tag">{{ $day->day_name }}: {{ $day->focus ?: 'General' }}</span>
                        @endforeach
                    </div>

                    <div class="routine-meta-strip mb-3">
                        <span><i class="bi bi-list-ol"></i> {{ $plan->exerciseCount() }} ejercicios</span>
                        <span><i class="bi bi-camera-video"></i> {{ $plan->evidenceCount() }} evidencias</span>
                        <span><i class="bi bi-calendar-week"></i> {{ $plan->days_per_week }} dias</span>
                    </div>

                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.rutinas.detalle', $plan) }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver estructura</a>
                        <a href="{{ route('fitapp.admin.rutinas.edit', $plan) }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                        @if($plan->user)
                            <a href="{{ route('fitapp.admin.usuarios.detalle', $plan->user) }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Usuario</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
