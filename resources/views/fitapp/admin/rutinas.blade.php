@extends('layouts.fitapp-admin')

@section('title', 'Rutinas | FitCoach Admin')

@section('content')
@php
    $routines = [
        [
            'name' => 'Masa muscular - Intermedio',
            'goal' => 'Hipertrofia y progresion de cargas',
            'meta' => '4 dias - gimnasio - 4 semanas',
            'status' => 'Activa',
            'days' => ['Lunes: Pierna', 'Martes: Espalda', 'Jueves: Pecho', 'Viernes: Gluteo'],
            'blocks' => '18 ejercicios - 3 biseries - 7 evidencias',
            'desc' => 'Plan semanal con ejercicios de biblioteca, descansos controlados y videos obligatorios para tecnica.',
        ],
        [
            'name' => 'Definicion - Casa',
            'goal' => 'Gasto calorico y fuerza general',
            'meta' => '3 dias - sin equipo avanzado - 6 semanas',
            'status' => 'Plantilla',
            'days' => ['Pierna', 'Core', 'HIIT'],
            'blocks' => '14 ejercicios - 2 circuitos - 3 evidencias',
            'desc' => 'Rutina preconfigurada para usuarios que entrenan en casa con mancuernas o peso corporal.',
        ],
        [
            'name' => 'Adulto mayor - Movilidad',
            'goal' => 'Fuerza basica, estabilidad y seguridad',
            'meta' => '3 dias - bajo impacto - 4 semanas',
            'status' => 'Revision',
            'days' => ['Movilidad', 'Estabilidad', 'Tren inferior'],
            'blocks' => '12 ejercicios - sin biseries - 4 evidencias',
            'desc' => 'Disenada para control motor, salud articular y ejecucion segura.',
        ],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Rutinas</h1>
        <div class="admin-topbar-subtitle">Construye planes desde la biblioteca: ejercicios, proposito, series, descansos, biseries y evidencias.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="btn btn-primary-custom px-4">
            Nueva rutina
        </a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Rutinas activas</div>
        <div class="admin-stat-value">12</div>
        <div class="admin-stat-note">Listas para asignar</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Plantillas</div>
        <div class="admin-stat-value">8</div>
        <div class="admin-stat-note">Basico, intermedio y avanzado</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Con biseries</div>
        <div class="admin-stat-value">5</div>
        <div class="admin-stat-note">Bloques combinados</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Evidencias</div>
        <div class="admin-stat-value">26</div>
        <div class="admin-stat-note">Ejercicios con video requerido</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todas</span>
    <span class="admin-filter-chip">Personalizadas</span>
    <span class="admin-filter-chip">Plantillas</span>
    <span class="admin-filter-chip">Con biseries</span>
    <span class="admin-filter-chip">Con evidencia</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar rutina...">
    </div>
</div>

<div class="admin-card-grid">
    @foreach($routines as $routine)
        <div class="admin-routine-card">
            <div class="admin-card-body">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <div class="admin-card-title">{{ $routine['name'] }}</div>
                        <div class="admin-card-text">{{ $routine['meta'] }}</div>
                    </div>
                    <span class="admin-tag {{ $routine['status'] === 'Activa' ? 'blue' : '' }}">
                        {{ $routine['status'] }}
                    </span>
                </div>

                <div class="routine-purpose-box mb-3">
                    <div class="admin-mini mb-1">Proposito</div>
                    <div class="fw-bold">{{ $routine['goal'] }}</div>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($routine['days'] as $day)
                        <span class="admin-tag">{{ $day }}</span>
                    @endforeach
                </div>

                <div class="admin-card-text mb-3">{{ $routine['desc'] }}</div>

                <div class="routine-meta-strip mb-3">
                    <span><i class="bi bi-list-ol"></i> {{ $routine['blocks'] }}</span>
                </div>

                <div class="admin-card-actions">
                    <a href="{{ route('fitapp.admin.rutinas.detalle') }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver estructura</a>
                    <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                    <a href="#" class="admin-btn-soft"><i class="bi bi-person-plus"></i> Asignar</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
