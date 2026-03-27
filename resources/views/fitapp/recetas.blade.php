@extends('layouts.fitapp')

@section('title', 'Recetas | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.plan') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <button class="app-bar-btn text-dark" type="button">
            <i class="bi bi-sliders"></i>
        </button>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-stars"></i> Sugerencias
        </div>
        <h1 class="fit-title mb-2">Recetas para ti</h1>
        <p class="fit-subtitle mb-0">
            Basadas en tu plan, tus ingredientes y el objetivo actual.
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap mb-4">
        <span class="chip active">Alta proteína</span>
        <span class="chip">Rápidas</span>
        <span class="chip">Económicas</span>
        <span class="chip">Bajo en carbohidratos</span>
    </div>

    <div class="d-grid gap-3">
        <div class="recipe-card">
            <div class="recipe-cover"></div>
            <div class="p-3">
                <div class="fw-bold mb-1">Bowl de pollo con arroz</div>
                <div class="fit-subtitle mb-3">15 min · alta proteína · fácil</div>
                <a href="#" class="btn btn-soft-custom w-100">Ver receta</a>
            </div>
        </div>

        <div class="recipe-card">
            <div class="recipe-cover"></div>
            <div class="p-3">
                <div class="fw-bold mb-1">Wrap de atún y aguacate</div>
                <div class="fit-subtitle mb-3">10 min · práctico · ligero</div>
                <a href="#" class="btn btn-soft-custom w-100">Ver receta</a>
            </div>
        </div>

        <div class="recipe-card">
            <div class="recipe-cover"></div>
            <div class="p-3">
                <div class="fw-bold mb-1">Avena proteica con fruta</div>
                <div class="fit-subtitle mb-3">8 min · desayuno · energía</div>
                <a href="#" class="btn btn-soft-custom w-100">Ver receta</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
