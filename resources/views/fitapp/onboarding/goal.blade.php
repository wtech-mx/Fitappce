@extends('layouts.fitapp')

@section('title', 'Objetivo | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.welcome') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Paso 1 de 5</span>
    </div>

    <div class="progress-slim mb-4">
        <div class="bar" style="width:20%;"></div>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-bullseye"></i> Objetivo
        </div>
        <h1 class="fit-title mb-2">¿Cuál es tu objetivo?</h1>
        <p class="fit-subtitle mb-0">
            Esta selección ayuda a definir el tipo de entrenamiento, intensidad y recomendaciones del plan.
        </p>
    </div>

    <div class="row g-3">
        <div class="col-6">
            <div class="option-card active h-100">
                <div class="option-icon">
                    <i class="bi bi-bar-chart-line"></i>
                </div>
                <div class="option-title">Aumento de Masa Muscular</div>
                <div class="option-text">Aumentar  tamaño muscular y mejoramiento de la estética corporal.</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <div class="option-title">Potencializar o Acondicionar alguna capacidad Física Condicional</div>
                <div class="option-text">Fuerza, Velocidad, Resistencia o Flexibilidad (Plan personalizado exclusivamente)</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-fire"></i>
                </div>
                <div class="option-title">Disminuir grasa corporal</div>
                <div class="option-text">Mejorar el tono muscular y reducir grasa corporal subcutánea.</div>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <a href="{{ route('fitapp.onboarding.service') }}" class="btn btn-primary-custom w-100">
            Continuar
        </a>
    </div>
</div>
@endsection
