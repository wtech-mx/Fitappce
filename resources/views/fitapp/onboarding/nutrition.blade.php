@extends('layouts.fitapp')

@section('title', 'Nutrición | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.training') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Paso 4 de 5</span>
    </div>

    <div class="progress-slim mb-4">
        <div class="bar" style="width:80%;"></div>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-cup-hot"></i> Nutrición
        </div>
        <h1 class="fit-title mb-2">Ahora tu parte alimentaria</h1>
        <p class="fit-subtitle mb-0">
            Esto sirve para que el entrenador prepare un plan realista y que la app sugiera recetas congruentes.
        </p>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">¿Cuántas comidas haces al día?</label>
        <select class="form-select input-soft">
            <option>3 comidas</option>
            <option>4 comidas</option>
            <option>5 comidas</option>
            <option>6 comidas</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Restricciones alimentarias</label>
        <select class="form-select input-soft">
            <option>Ninguna</option>
            <option>Vegetariano</option>
            <option>Vegano</option>
            <option>Sin lactosa</option>
            <option>Sin gluten</option>
            <option>Personalizado</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Alimentos que no te gustan</label>
        <textarea class="form-control input-soft py-3" rows="3" placeholder="Ej. atún, brócoli, leche, avena..."></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Horario más complicado para comer</label>
        <select class="form-select input-soft">
            <option>Mañana</option>
            <option>Mediodía</option>
            <option>Tarde</option>
            <option>Noche</option>
            <option>Ninguno</option>
        </select>
    </div>

    <div class="card-soft p-3 rounded-24">
        <div class="fw-bold mb-1">Buen UX tip</div>
        <div class="fit-subtitle">
            El usuario debe sentir que el plan se adapta a su vida, no que la app le va a regañar por existir.
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('fitapp.onboarding.summary') }}" class="btn btn-primary-custom w-100">
            Continuar
        </a>
    </div>
</div>
@endsection
