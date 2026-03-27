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
        <h1 class="fit-title mb-2">¿Qué quieres lograr?</h1>
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
                <div class="option-title">Masa muscular</div>
                <div class="option-text">Subir volumen y mejorar desarrollo muscular.</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <div class="option-title">Definición</div>
                <div class="option-text">Reducir grasa y mejorar composición corporal.</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-trophy"></i>
                </div>
                <div class="option-title">Fuerza</div>
                <div class="option-text">Mayor rendimiento y capacidad de carga.</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="option-title">Adulto mayor</div>
                <div class="option-text">Movilidad, salud articular y autonomía.</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-fire"></i>
                </div>
                <div class="option-title">Pérdida de peso</div>
                <div class="option-text">Déficit calórico con entrenamiento controlado.</div>
            </div>
        </div>

        <div class="col-6">
            <div class="option-card h-100">
                <div class="option-icon">
                    <i class="bi bi-emoji-smile"></i>
                </div>
                <div class="option-title">Bienestar</div>
                <div class="option-text">Sentirte mejor y crear constancia real.</div>
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
