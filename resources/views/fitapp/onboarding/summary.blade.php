@extends('layouts.fitapp')

@section('title', 'Resumen | FitApp')

@section('content')
<div class="section-pad d-flex flex-column min-vh-100">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.nutrition') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Paso 5 de 5</span>
    </div>

    <div class="progress-slim mb-4">
        <div class="bar" style="width:100%;"></div>
    </div>

    <div class="hero-card hero-blue mb-4">
        <div class="page-kicker text-white">
            <i class="bi bi-check2-circle"></i> Todo listo
        </div>
        <h1 class="fit-title text-white mb-2">Ya tenemos tu perfil inicial</h1>
        <p class="text-white-50 mb-0">
            Esto es lo que usará la app para construir tu experiencia y lo que verá el entrenador para preparar tu material.
        </p>
    </div>

    <div class="surface-card p-4 mb-3">
        <div class="fw-bold mb-3">Resumen</div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Objetivo</span>
            <span class="fw-bold">Masa muscular</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Servicio</span>
            <span class="fw-bold">Rutina + nutrición</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Tipo de plan</span>
            <span class="fw-bold">Personalizado</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Frecuencia</span>
            <span class="fw-bold">3 días por semana</span>
        </div>

        <div class="d-flex justify-content-between">
            <span class="text-muted">Entrenamiento</span>
            <span class="fw-bold">Gimnasio</span>
        </div>
    </div>

    <div class="card-soft p-4 rounded-24 mb-4">
        <div class="fw-bold mb-2">Lo que verás después</div>
        <ul class="info-list mb-0">
            <li>Tu rutina organizada por semanas y días</li>
            <li>Evidencias para subir videos y fotos</li>
            <li>Plan alimentario y recetas sugeridas</li>
            <li>Seguimiento de progreso y cumplimiento</li>
        </ul>
    </div>

    <div class="mt-auto">
        <a href="{{ route('fitapp.dashboard') }}" class="btn btn-accent-custom w-100">
            Ir a mi dashboard
        </a>
    </div>
</div>
@endsection
