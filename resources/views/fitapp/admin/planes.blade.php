@extends('layouts.fitapp-admin')

@section('title', 'Planes | FitCoach Admin')

@section('content')
@php
    $plans = [
        [
            'name' => 'Masa muscular - Base 8 semanas',
            'type' => 'Predefinido',
            'goal' => 'Aumento de masa muscular',
            'status' => 'Activo',
            'meta' => '8 semanas - 4 dias - gimnasio',
            'routines' => ['Hipertrofia A', 'Hipertrofia B'],
            'desc' => 'Estructura fija para usuarios intermedios con progresion de cargas y evidencia en ejercicios base.',
            'renewal' => 'No cambia mes a mes',
        ],
        [
            'name' => 'Personalizado mensual - Maria Gonzalez',
            'type' => 'Personalizado',
            'goal' => 'Gluteo y recomposicion',
            'status' => 'En seguimiento',
            'meta' => 'Mes 2 - 5 dias - gimnasio',
            'routines' => ['Pierna fuerza', 'Superior tecnico', 'Gluteo volumen'],
            'desc' => 'Plan ajustado con base en evidencias, progreso, medidas y disponibilidad semanal de la usuaria.',
            'renewal' => 'Se actualiza cada mes',
        ],
        [
            'name' => 'Definicion en casa - 6 semanas',
            'type' => 'Predefinido',
            'goal' => 'Disminuir grasa corporal',
            'status' => 'Plantilla',
            'meta' => '6 semanas - 3 dias - casa',
            'routines' => ['Full body casa', 'Core + HIIT'],
            'desc' => 'Plan cerrado para usuarios que entrenan con mancuernas, bandas o peso corporal.',
            'renewal' => 'Limite fijo por objetivo',
        ],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Planes</h1>
        <div class="admin-topbar-subtitle">Crea planes desde rutinas. Los predefinidos tienen duracion fija; los personalizados cambian mes a mes.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.planes.crear') }}" class="btn btn-primary-custom px-4">Nuevo plan</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Planes activos</div>
        <div class="admin-stat-value">16</div>
        <div class="admin-stat-note">Asignables a usuarios</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Predefinidos</div>
        <div class="admin-stat-value">9</div>
        <div class="admin-stat-note">Objetivo y duracion fija</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Personalizados</div>
        <div class="admin-stat-value">7</div>
        <div class="admin-stat-note">Renovacion mensual</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Por renovar</div>
        <div class="admin-stat-value">4</div>
        <div class="admin-stat-note">Vencen esta semana</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todos</span>
    <span class="admin-filter-chip">Predefinidos</span>
    <span class="admin-filter-chip">Personalizados</span>
    <span class="admin-filter-chip">Por renovar</span>
    <span class="admin-filter-chip">Plantillas</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar plan, usuario u objetivo...">
    </div>
</div>

<div class="admin-card-grid">
    @foreach($plans as $plan)
        <div class="admin-plan-card">
            <div class="admin-card-body">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <div class="admin-card-title">{{ $plan['name'] }}</div>
                        <div class="admin-card-text">{{ $plan['meta'] }}</div>
                    </div>
                    <span class="admin-tag {{ $plan['type'] === 'Personalizado' ? 'yellow' : 'blue' }}">{{ $plan['type'] }}</span>
                </div>

                <div class="routine-purpose-box mb-3">
                    <div class="admin-mini mb-1">Objetivo</div>
                    <div class="fw-bold">{{ $plan['goal'] }}</div>
                    <div class="admin-card-text mt-1">{{ $plan['renewal'] }}</div>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="admin-tag">{{ $plan['status'] }}</span>
                    @foreach($plan['routines'] as $routine)
                        <span class="admin-tag blue">{{ $routine }}</span>
                    @endforeach
                </div>

                <div class="admin-card-text">{{ $plan['desc'] }}</div>

                <div class="admin-card-actions">
                    <a href="{{ route('fitapp.admin.planes.detalle') }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver plan</a>
                    <a href="{{ route('fitapp.admin.planes.crear') }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                    <a href="{{ route('fitapp.admin.usuarios') }}" class="admin-btn-soft"><i class="bi bi-person-plus"></i> Asignar</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
