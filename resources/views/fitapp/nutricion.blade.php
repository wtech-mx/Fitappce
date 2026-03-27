@extends('layouts.fitapp')

@section('title', 'Nutrición diaria | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.dashboard') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <a href="{{ route('fitapp.plan') }}" class="app-bar-btn text-dark">
            <i class="bi bi-journal-text"></i>
        </a>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-cup-hot"></i> Nutrición de hoy
        </div>
        <h1 class="fit-title mb-2">Registra tus comidas</h1>
        <p class="fit-subtitle mb-0">
            Sube las evidencias que te pidió el coach y revisa rápido tu plan alimentario.
        </p>
    </div>

    <div class="hero-card hero-blue mb-4">
        <div class="row text-center g-3">
            <div class="col-4">
                <div class="fw-bold fs-5">5</div>
                <small class="text-white-50">Comidas</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">3</div>
                <small class="text-white-50">Pendientes</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">2100</div>
                <small class="text-white-50">Kcal</small>
            </div>
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Comidas del día</h2>
        <a href="{{ route('fitapp.plan') }}" class="small text-decoration-none text-primary-custom">Ver plan</a>
    </div>

    <div class="d-grid gap-3 mb-4">
        <button type="button" class="meal-card-btn">
            <div class="exercise-card">
                <div class="exercise-card-head mb-2">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="meal-thumb">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Desayuno</div>
                            <div class="exercise-sub">Avena + plátano + claras + café</div>
                            <div class="exercise-tags">
                                <span class="exercise-tag">
                                    <i class="bi bi-camera"></i> Foto enviada
                                </span>
                            </div>
                        </div>
                    </div>

                    <span class="status-pill status-ok">Enviado</span>
                </div>
            </div>
        </button>

        <button type="button" class="meal-card-btn">
            <div class="exercise-card">
                <div class="exercise-card-head mb-2">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="meal-thumb">
                            <i class="bi bi-egg-fried"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Comida</div>
                            <div class="exercise-sub">Pollo a la plancha + arroz + verduras</div>
                            <div class="exercise-tags">
                                <span class="exercise-tag is-required">
                                    <i class="bi bi-camera"></i> Evidencia requerida
                                </span>
                            </div>
                        </div>
                    </div>

                    <span class="status-pill status-warn">Pendiente</span>
                </div>

                <div class="exercise-actions">
                    <span class="btn-chip btn-chip-warning">
                        <i class="bi bi-image"></i> Subir foto
                    </span>
                </div>
            </div>
        </button>

        <button type="button" class="meal-card-btn">
            <div class="exercise-card">
                <div class="exercise-card-head mb-2">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="meal-thumb">
                            <i class="bi bi-cup-straw"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Colación</div>
                            <div class="exercise-sub">Yogurt griego + nueces</div>
                            <div class="exercise-tags">
                                <span class="exercise-tag is-required">
                                    <i class="bi bi-camera"></i> Evidencia requerida
                                </span>
                            </div>
                        </div>
                    </div>

                    <span class="status-pill status-warn">Pendiente</span>
                </div>

                <div class="exercise-actions">
                    <span class="btn-chip btn-chip-warning">
                        <i class="bi bi-image"></i> Subir foto
                    </span>
                </div>
            </div>
        </button>

        <button type="button" class="meal-card-btn">
            <div class="exercise-card">
                <div class="exercise-card-head mb-2">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="meal-thumb">
                            <i class="bi bi-moon-stars"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Cena</div>
                            <div class="exercise-sub">Atún + aguacate + ensalada</div>
                            <div class="exercise-tags">
                                <span class="exercise-tag is-required">
                                    <i class="bi bi-camera"></i> Evidencia requerida
                                </span>
                            </div>
                        </div>
                    </div>

                    <span class="status-pill status-danger">Sin registrar</span>
                </div>

                <div class="exercise-actions">
                    <span class="btn-chip btn-chip-warning">
                        <i class="bi bi-image"></i> Subir foto
                    </span>
                </div>
            </div>
        </button>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <a href="{{ route('fitapp.plan') }}" class="quick-link-card primary">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="page-kicker mb-1">
                            <i class="bi bi-journal-text"></i> Plan alimentario
                        </div>
                        <div class="fw-bold mb-1">Ver plan completo del día</div>
                        <div class="fit-subtitle">Macros, comidas y observaciones del entrenador.</div>
                    </div>
                    <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
                </div>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route('fitapp.recetas') }}" class="quick-link-card">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="page-kicker mb-1">
                            <i class="bi bi-stars"></i> Recetas
                        </div>
                        <div class="fw-bold mb-1">Sugerencias basadas en tu plan</div>
                        <div class="fit-subtitle">Opciones rápidas, altas en proteína y fáciles de preparar.</div>
                    </div>
                    <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
