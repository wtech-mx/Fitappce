@extends('layouts.fitapp')

@section('title', 'Plan alimentario | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.nutricion') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <a href="{{ route('fitapp.recetas') }}" class="app-bar-btn text-dark">
            <i class="bi bi-book"></i>
        </a>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-journal-text"></i> Nutrición
        </div>
        <h1 class="fit-title mb-2">Tu plan alimentario</h1>
        <p class="fit-subtitle mb-0">
            Este resumen concentra las comidas del día, lineamientos y enfoque que definió el entrenador.
        </p>
    </div>

    <div class="hero-card hero-blue mb-4">
        <div class="row text-center g-3">
            <div class="col-4">
                <div class="fw-bold fs-5">2100</div>
                <small class="text-white-50">Kcal</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">160g</div>
                <small class="text-white-50">Proteína</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">5</div>
                <small class="text-white-50">Comidas</small>
            </div>
        </div>
    </div>

    <div class="d-grid gap-3 mb-4">
        <div class="day-card p-3">
            <div class="fw-bold mb-1">Desayuno</div>
            <div class="fit-subtitle">Avena + plátano + claras + café</div>
        </div>

        <div class="day-card p-3">
            <div class="fw-bold mb-1">Colación</div>
            <div class="fit-subtitle">Yogurt griego + nueces</div>
        </div>

        <div class="day-card p-3">
            <div class="fw-bold mb-1">Comida</div>
            <div class="fit-subtitle">Pollo a la plancha + arroz + verduras</div>
        </div>

        <div class="day-card p-3">
            <div class="fw-bold mb-1">Cena</div>
            <div class="fit-subtitle">Atún con aguacate + ensalada</div>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Indicaciones del entrenador</div>
        <ul class="info-list mb-0">
            <li>Priorizar proteína en cada comida</li>
            <li>Evitar bebidas azucaradas</li>
            <li>Tomar 2 litros de agua mínimo</li>
            <li>Mandar foto de comida y cena</li>
        </ul>
    </div>

    <a href="{{ route('fitapp.recetas') }}" class="btn btn-primary-custom w-100">
        Ver recetas sugeridas
    </a>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
