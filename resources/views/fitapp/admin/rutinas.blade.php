@extends('layouts.fitapp-admin')

@section('title', 'Rutinas | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Rutinas</h1>
        <div class="admin-topbar-subtitle">Planes semanales, días de entrenamiento y ejercicios con evidencia obligatoria.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-primary-custom px-4">Nueva rutina</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-card-grid">
    <div class="admin-routine-card">
        <div class="admin-card-body">
            <div class="admin-card-title">Rutina Masa Muscular · Nivel Intermedio</div>
            <div class="admin-card-text mb-3">4 días · gimnasio · 4 semanas</div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag">Lunes: Pierna</span>
                <span class="admin-tag">Martes: Espalda</span>
                <span class="admin-tag">Jueves: Pecho</span>
                <span class="admin-tag">Viernes: Glúteo</span>
            </div>

            <div class="admin-card-text">
                Incluye ejercicios demo y algunos con evidencia requerida para evaluación técnica.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver rutina</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
            </div>
        </div>
    </div>

    <div class="admin-routine-card">
        <div class="admin-card-body">
            <div class="admin-card-title">Rutina Definición · Casa</div>
            <div class="admin-card-text mb-3">3 días · sin equipo avanzado</div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag">Pierna</span>
                <span class="admin-tag">Core</span>
                <span class="admin-tag">HIIT</span>
            </div>

            <div class="admin-card-text">
                Plan preconfigurado listo para asignar a prospectos que aún no pasan a personalizado.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-person-plus"></i> Asignar</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
            </div>
        </div>
    </div>

    <div class="admin-routine-card">
        <div class="admin-card-body">
            <div class="admin-card-title">Rutina Adulto Mayor</div>
            <div class="admin-card-text mb-3">3 días · movilidad y fuerza básica</div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag">Movilidad</span>
                <span class="admin-tag">Estabilidad</span>
                <span class="admin-tag">Bajo impacto</span>
            </div>

            <div class="admin-card-text">
                Diseñada para salud articular, control motor y seguridad en ejecución.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-copy"></i> Duplicar</a>
            </div>
        </div>
    </div>
</div>
@endsection
