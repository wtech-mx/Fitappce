@extends('layouts.fitapp')

@section('title', 'Servicio | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.goal') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Paso 2 de 5</span>
    </div>

    <div class="progress-slim mb-4">
        <div class="bar" style="width:40%;"></div>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-grid"></i> Servicio
        </div>
        <h1 class="fit-title mb-2">¿Qué quieres contratar?</h1>
        <p class="fit-subtitle mb-0">
            Aquí definimos si el usuario solo quiere entrenar o también desea acompañamiento nutricional.
        </p>
    </div>

    <div class="d-grid gap-3 mb-4">
        <div class="option-card">
            <div class="d-flex gap-3">
                <div class="option-icon mb-0">
                    <i class="bi bi-activity"></i>
                </div>
                <div>
                    <div class="option-title">Solo rutina</div>
                    <div class="option-text">Entrenamientos previamente cargados y organizados por semana.</div>
                </div>
            </div>
        </div>

        <div class="option-card">
            <div class="d-flex gap-3">
                <div class="option-icon mb-0">
                    <i class="bi bi-cup-straw"></i>
                </div>
                <div>
                    <div class="option-title">Solo plan nutricional</div>
                    <div class="option-text">Plan de comidas, evidencia fotográfica y seguimiento del coach.</div>
                </div>
            </div>
        </div>

        <div class="option-card active">
            <div class="d-flex gap-3">
                <div class="option-icon mb-0">
                    <i class="bi bi-stars"></i>
                </div>
                <div>
                    <div class="option-title">Rutina + nutrición</div>
                    <div class="option-text">Experiencia completa con entrenamiento, comidas, evidencias y evaluación.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Tipo de plan de entrenamiento</label>
        <select class="form-select input-soft">
            <option>Plan básico preconfigurado</option>
            <option>Plan intermedio preconfigurado</option>
            <option>Plan avanzado preconfigurado</option>
            <option>Plan personalizado por entrenador</option>
        </select>
    </div>

    <div class="card-soft p-3 rounded-24">
        <div class="fw-bold mb-1">Tip visual</div>
        <div class="fit-subtitle">
            El plan personalizado es el que más valor vende, así que visualmente conviene destacarlo más adelante.
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('fitapp.onboarding.training') }}" class="btn btn-primary-custom w-100">
            Continuar
        </a>
    </div>
</div>
@endsection
