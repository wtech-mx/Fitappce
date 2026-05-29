@extends('layouts.fitapp')

@section('title', 'Nutricion diaria | FitApp')

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
            <i class="bi bi-cup-hot"></i> Nutricion de hoy
        </div>
        <h1 class="fit-title mb-2">Registra tus comidas</h1>
        <p class="fit-subtitle mb-0">
            Revisa rapido tu plan alimentario activo y las comidas del dia.
        </p>
    </div>

    <div class="hero-card hero-blue mb-4">
        <div class="row text-center g-3">
            <div class="col-4">
                <div class="fw-bold fs-5">{{ $activePlan?->meals->count() ?: '-' }}</div>
                <small class="text-white-50">Comidas</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">{{ $activePlan ? number_format((float) $activePlan->target_protein, 0).'g' : '-' }}</div>
                <small class="text-white-50">Proteina</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">{{ $activePlan ? number_format((float) $activePlan->target_calories, 0) : '-' }}</div>
                <small class="text-white-50">Kcal</small>
            </div>
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Comidas del dia</h2>
        <a href="{{ route('fitapp.plan') }}" class="small text-decoration-none text-primary-custom">Ver plan</a>
    </div>

    <div class="d-grid gap-3 mb-4">
        @forelse ($activePlan?->meals ?? [] as $meal)
            <button type="button" class="meal-card-btn">
                <div class="exercise-card">
                    <div class="exercise-card-head mb-2">
                        <div class="d-flex gap-3 flex-grow-1">
                            <div class="meal-thumb">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="exercise-title">{{ $meal->name }}</div>
                                <div class="exercise-sub">{{ $meal->items->pluck('food_name')->join(' + ') ?: 'Sin alimentos capturados' }}</div>
                                <div class="exercise-tags">
                                    <span class="exercise-tag is-required">
                                        <i class="bi bi-camera"></i> Evidencia opcional
                                    </span>
                                </div>
                            </div>
                        </div>

                        <span class="status-pill status-warn">Pendiente</span>
                    </div>
                </div>
            </button>
        @empty
            <div class="surface-card p-4">
                <div class="fw-bold mb-2">Plan pendiente</div>
                <div class="fit-subtitle">Tu coach aun no ha activado un plan alimentario.</div>
            </div>
        @endforelse
    </div>

    <div class="row g-3">
        <div class="col-12">
            <a href="{{ route('fitapp.plan') }}" class="quick-link-card primary">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="page-kicker mb-1">
                            <i class="bi bi-journal-text"></i> Plan alimentario
                        </div>
                        <div class="fw-bold mb-1">Ver plan completo del dia</div>
                        <div class="fit-subtitle">Macros, comidas y observaciones del entrenador.</div>
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
