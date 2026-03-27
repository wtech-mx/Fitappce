@extends('layouts.fitapp')

@section('title', 'Bienvenida | FitApp')

@section('content')
<div class="section-pad d-flex flex-column min-vh-100">
    <div class="app-bar">
        <a href="{{ route('fitapp.auth') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Onboarding</span>
    </div>

    <div class="hero-card hero-dark mb-4">
        <div class="page-kicker text-white">
            <i class="bi bi-stars"></i> Plan inteligente
        </div>
        <h1 class="fit-title text-white mb-2">Vamos a crear tu plan ideal</h1>
        <p class="text-white-50 mb-0">
            En pocos pasos te mostraremos una experiencia adaptada a tu objetivo, tu nivel y tu estilo de vida.
        </p>
    </div>

    <div class="surface-card p-4 mb-3">
        <div class="d-flex gap-3 mb-3">
            <div class="option-icon mb-0">
                <i class="bi bi-activity"></i>
            </div>
            <div>
                <div class="option-title">Rutinas por día</div>
                <div class="option-text">Entrenamientos organizados por semana, con ejercicios claros y fáciles de seguir.</div>
            </div>
        </div>

        <div class="d-flex gap-3 mb-3">
            <div class="option-icon mb-0">
                <i class="bi bi-camera"></i>
            </div>
            <div>
                <div class="option-title">Evidencias y seguimiento</div>
                <div class="option-text">Sube videos o fotos para que tu entrenador evalúe tu técnica y adherencia.</div>
            </div>
        </div>

        <div class="d-flex gap-3">
            <div class="option-icon mb-0">
                <i class="bi bi-cup-hot"></i>
            </div>
            <div>
                <div class="option-title">Nutrición y recetas</div>
                <div class="option-text">Visualiza tu plan alimentario y recibe ideas de comidas compatibles con tus objetivos.</div>
            </div>
        </div>
    </div>

    <div class="card-soft p-4 rounded-24 mb-4">
        <div class="fw-bold mb-2">¿Qué haremos aquí?</div>
        <div class="fit-subtitle">
            Elegir objetivo, tipo de servicio, frecuencia de entrenamiento, restricciones alimentarias y el enfoque de tu plan.
        </div>
    </div>

    <div class="mt-auto">
        <a href="{{ route('fitapp.onboarding.goal') }}" class="btn btn-primary-custom w-100">
            Empezar
        </a>
    </div>
</div>
@endsection
