@extends('layouts.fitapp')

@section('title', 'Acceso | FitApp')

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
                <i class="bi bi-camera"></i>
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
                <i class="bi bi-camera"></i>
            </div>
            <div>
                <div class="fw-bold">Guianza y Orientación</div>
                <div class="small text-white-50">
                    Puedes recibir la guianza u orientación a distancia de tu entrenador compartiendo tus evidencias subiendo tus videos de ejercicios o comidas que estés realizando.
                </div>
            </div>
        </div>

    </div>

    <ul class="nav nav-pills mb-4" id="authTabs" role="tablist">
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link active w-100" id="login-tab" data-bs-toggle="pill" data-bs-target="#login-pane" type="button">
                Iniciar sesión
            </button>
        </li>
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link w-100" id="register-tab" data-bs-toggle="pill" data-bs-target="#register-pane" type="button">
                Crear cuenta
            </button>
        </li>
    </ul>

    <div class="tab-content">
        {{-- LOGIN --}}
        <div class="tab-pane fade show active" id="login-pane">
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

                <a href="{{ route('fitapp.onboarding.welcome') }}" class="btn btn-primary-custom w-100">
                    Entrar
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
                    Crear cuenta
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
