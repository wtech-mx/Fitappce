@extends('layouts.fitapp')

@section('title', 'Onboarding | FitApp')

@section('content')
<div class="section-pad">
    <div class="d-flex align-items-center justify-content-between mb-4 pt-2">
        <a href="{{ route('fitapp.auth') }}" class="text-decoration-none text-dark">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <span class="small text-muted fw-semibold">Paso 1 de 4</span>
    </div>

    <div class="mb-4">
        <h1 class="fit-title mb-2">Personalicemos tu plan</h1>
        <p class="fit-subtitle mb-0">
            Responde estas preguntas para adaptar tu entrenamiento y nutrición.
        </p>
    </div>

    <div class="progress rounded-pill mb-4" style="height:10px;">
        <div class="progress-bar" role="progressbar" style="width: 25%; background:#2E86AB;"></div>
    </div>

    {{-- OBJETIVO --}}
    <div class="mb-4">
        <label class="form-label fw-bold">¿Cuál es tu objetivo principal?</label>

        <div class="row g-3">
            <div class="col-6">
                <div class="card card-soft h-100 rounded-20">
                    <div class="card-body">
                        <div class="mb-2 fs-4 text-primary-custom">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div class="fw-bold">Masa muscular</div>
                        <small class="text-muted">Subir volumen</small>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card card-soft h-100 rounded-20 border border-2" style="border-color:#2E86AB !important;">
                    <div class="card-body">
                        <div class="mb-2 fs-4 text-primary-custom">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="fw-bold">Definición</div>
                        <small class="text-muted">Reducir grasa</small>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card card-soft h-100 rounded-20">
                    <div class="card-body">
                        <div class="mb-2 fs-4 text-primary-custom">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="fw-bold">Fuerza</div>
                        <small class="text-muted">Mayor rendimiento</small>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card card-soft h-100 rounded-20">
                    <div class="card-body">
                        <div class="mb-2 fs-4 text-primary-custom">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div class="fw-bold">Adulto mayor</div>
                        <small class="text-muted">Movilidad y salud</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TIPO DE PLAN --}}
    <div class="mb-4">
        <label class="form-label fw-bold">¿Qué deseas contratar?</label>
        <div class="d-grid gap-3">
            <div class="card card-soft rounded-20">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Solo rutina</div>
                        <small class="text-muted">Entrenamiento guiado</small>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>

            <div class="card card-soft rounded-20 border border-2" style="border-color:#2E86AB !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Rutina + nutrición</div>
                        <small class="text-muted">Plan completo</small>
                    </div>
                    <i class="bi bi-check-circle-fill text-primary-custom"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- PLAN --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Selecciona un tipo de plan</label>
        <select class="form-select input-soft">
            <option>Plan básico</option>
            <option>Plan intermedio</option>
            <option>Plan avanzado</option>
            <option>Plan personalizado</option>
        </select>
    </div>

    {{-- FRECUENCIA --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Frecuencia de entrenamiento</label>
        <div class="d-flex flex-wrap gap-2">
            <span class="week-chip active">3 días</span>
            <span class="week-chip">4 días</span>
            <span class="week-chip">5 días</span>
            <span class="week-chip">6 días</span>
        </div>
    </div>

    {{-- LUGAR --}}
    <div class="mb-4">
        <label class="form-label fw-bold">¿Dónde entrenas?</label>
        <select class="form-select input-soft">
            <option>Gimnasio</option>
            <option>Casa</option>
            <option>Ambos</option>
        </select>
    </div>

    {{-- RESTRICCIONES --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Restricciones alimentarias</label>
        <select class="form-select input-soft">
            <option>Ninguna</option>
            <option>Vegetariano</option>
            <option>Vegano</option>
            <option>Sin lactosa</option>
            <option>Sin gluten</option>
            <option>Otro</option>
        </select>
    </div>

    <div class="d-grid pt-2">
        <a href="{{ route('fitapp.dashboard') }}" class="btn btn-primary-custom">
            Continuar
        </a>
    </div>
</div>
@endsection
