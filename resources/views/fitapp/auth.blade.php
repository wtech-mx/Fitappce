@extends('layouts.fitapp')

@section('title', 'Acceso | FitApp')

@push('styles')
<style>
    .auth-entry-actions .nav-link{
        min-height:54px;
        border-radius:18px;
        font-weight:800;
    }

    .auth-entry-actions .nav-link:not(.active){
        background:var(--fa-soft);
        color:var(--fa-dark);
    }

    .auth-more-btn{
        border:1px solid rgba(255,255,255,.18);
        background:rgba(255,255,255,.1);
        color:#fff;
        min-height:42px;
        border-radius:999px;
        padding:0 16px;
        font-weight:800;
        display:inline-flex;
        align-items:center;
        gap:8px;
    }

    .auth-more-btn:hover,
    .auth-more-btn:focus{
        color:#fff;
        background:rgba(255,255,255,.16);
    }
</style>
@endpush

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.splash') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Acceso</span>
    </div>

    <div class="auth-hero mb-4">
        <div class="auth-badge mb-3">
            <i class="bi bi-heart-pulse-fill"></i>
            Fitness + Nutrición
        </div>

        <h1 class="fit-title text-white mb-2">Bienvenido a FitCoach</h1>
        <p class="text-white-50 mb-4">
            Tu entrenador, tu entrenamiento, tu alimentación, orientación y guianza en una sola app.
        </p>

        <button type="button" class="auth-more-btn mb-3" data-auth-more-trigger>
            <i class="bi bi-chevron-down" data-auth-more-icon></i>
            <span data-auth-more-text>Ver más</span>
        </button>

        <div class="d-none" data-auth-more-content>
            <div class="auth-feature mb-3">
                <div class="auth-feature-icon">
                    <i class="bi bi-activity"></i>
                </div>
                <div>
                    <div class="fw-bold">Entrenamiento</div>
                    <div class="small text-white-50">Puedes adquirir un plan de entrenamiento de acuerdo a tu objetivo estético o funcional que desees lograr.</div>
                </div>
            </div>

            <div class="auth-feature mb-3">
                <div class="auth-feature-icon">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <div>
                    <div class="fw-bold">Alimentación</div>
                    <div class="small text-white-50">
                        Se te puede elaborar un plan alimentario para ayudarte a lograr tu objetivo estético o funcional que desees lograr.
                    </div>
                </div>
            </div>

            <div class="auth-feature">
                <div class="auth-feature-icon">
                    <i class="bi bi-camera-video"></i>
                </div>
                <div>
                    <div class="fw-bold">Guianza y Orientación</div>
                    <div class="small text-white-50">
                        Puedes recibir la guianza u orientación a distancia de tu entrenador compartiendo tus evidencias subiendo tus videos de ejercicios o comidas que estés realizando.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills auth-entry-actions mb-4" id="authTabs" role="tablist">
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link w-100" id="login-tab" data-bs-toggle="pill" data-bs-target="#login-pane" type="button" data-auth-trigger>
                Iniciar sesión
            </button>
        </li>
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link w-100" id="register-tab" data-bs-toggle="pill" data-bs-target="#register-pane" type="button" data-auth-trigger>
                Crear cuenta
            </button>
        </li>
    </ul>

    <div class="tab-content d-none" id="authPanels">
        {{-- LOGIN --}}
        <div class="tab-pane fade" id="login-pane">
            <div class="surface-card p-4 mb-3">
                <div class="mb-3">
                    <label class="form-label fw-bold">Correo electrónico</label>
                    <input type="email" class="form-control input-soft" placeholder="coachfit@correo.com">
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold">Contraseña</label>
                    <input type="password" class="form-control input-soft" placeholder="********">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label small" for="rememberMe">
                            Recordarme
                        </label>
                    </div>

                    <a href="#" class="small text-decoration-none text-primary-custom">
                        Olvidé mi contraseña
                    </a>
                </div>

                <a href="{{ route('fitapp.dashboard') }}" class="btn btn-primary-custom w-100">
                    Entrar como usuario
                </a>

                <a href="{{ route('fitapp.admin.dashboard') }}" class="btn btn-soft-custom w-100 mt-2">
                    Entrar como administrador
                </a>
            </div>
        </div>

        {{-- REGISTER --}}
        <div class="tab-pane fade" id="register-pane">
            <div class="surface-card p-4 mb-3">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre completo</label>
                    <input type="text" class="form-control input-soft" placeholder="Tu nombre">
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-bold">Edad</label>
                        <input type="text" class="form-control input-soft" placeholder="25">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Sexo</label>
                        <select class="form-select input-soft">
                            <option>Selecciona</option>
                            <option>Hombre</option>
                            <option>Mujer</option>
                            <option>Otro</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-6">
                        <label class="form-label fw-bold">Peso</label>
                        <input type="text" class="form-control input-soft" placeholder="72 kg">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Estatura</label>
                        <input type="text" class="form-control input-soft" placeholder="1.74 m">
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label fw-bold">Teléfono</label>
                    <input type="text" class="form-control input-soft" placeholder="55 0000 0000">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Correo electrónico</label>
                    <input type="email" class="form-control input-soft" placeholder="correo@ejemplo.com">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Contraseña</label>
                    <input type="password" class="form-control input-soft" placeholder="********">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Confirmar contraseña</label>
                    <input type="password" class="form-control input-soft" placeholder="********">
                </div>

                <a href="{{ route('fitapp.onboarding.welcome') }}" class="btn btn-primary-custom w-100">
                    Crear cuenta y empezar onboarding
                </a>
            </div>

            <div class="card-soft p-3 rounded-24">
                <div class="fw-bold mb-1">Tip UX</div>
                <div class="fit-subtitle">
                    Aquí ya metimos los datos base fitness desde el registro para que el onboarding se sienta más personalizado.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const authPanels = document.getElementById('authPanels');

        document.querySelectorAll('[data-auth-trigger]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                authPanels?.classList.remove('d-none');
            });
        });

        const moreTrigger = document.querySelector('[data-auth-more-trigger]');
        const moreContent = document.querySelector('[data-auth-more-content]');
        const moreText = document.querySelector('[data-auth-more-text]');
        const moreIcon = document.querySelector('[data-auth-more-icon]');

        moreTrigger?.addEventListener('click', () => {
            const isHidden = moreContent?.classList.toggle('d-none');

            moreText?.replaceChildren(isHidden ? 'Ver más' : 'Ver menos');
            moreIcon?.classList.toggle('bi-chevron-down', isHidden);
            moreIcon?.classList.toggle('bi-chevron-up', !isHidden);
        });
    });
</script>
@endpush
