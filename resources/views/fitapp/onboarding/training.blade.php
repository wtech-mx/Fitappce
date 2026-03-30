@extends('layouts.fitapp')

@section('title', 'Entrenamiento | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.service') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Paso 3 de 5</span>
    </div>

    <div class="progress-slim mb-4">
        <div class="bar" style="width:60%;"></div>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-calendar-week"></i> Entrenamiento
        </div>
        <h1 class="fit-title mb-2">Cuéntanos los detalles para elaborar tu plan de entrenamiento.</h1>
        <p class="fit-subtitle mb-0">
            Esto ayuda a personalizar frecuencia, dificultad y estructura de cada semana.
        </p>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Tu nivel actual de entrenamiento</label>
        <select class="form-select input-soft">
            <option>Principiante</option>
            <option>Intermedio</option>
            <option>Avanzado</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">¿Cuántos días quieres entrenar?</label>
        <div class="d-flex flex-wrap gap-2">
            <span class="chip">2 días</span>
            <span class="chip active">3 días</span>
            <span class="chip">4 días</span>
            <span class="chip">5 días</span>
            <span class="chip">6 días</span>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">¿Tú entrenamiento en donde lo realizarás?</label>
        <select class="form-select input-soft">
            <option>Gimnasio</option>
            <option>Casa</option>
            <option>Ambos</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Tiempo disponible por sesión</label>
        <select class="form-select input-soft">
            <option>30 minutos</option>
            <option>45 minutos</option>
            <option>60 minutos</option>
            <option>90 minutos</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">¿Tienes alguna enfermedad, lesión o alguna contraindicacion que nos quieras informar?</label>
        <textarea class="form-control input-soft py-3" rows="3" placeholder="Ej. molestia en rodilla, dolor lumbar, hombro, etc."></textarea>
    </div>

    <div class="mt-4">
        <a href="{{ route('fitapp.onboarding.nutrition') }}" class="btn btn-primary-custom w-100">
            Continuar
        </a>
    </div>
</div>
@endsection
