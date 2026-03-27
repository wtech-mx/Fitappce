@extends('layouts.fitapp')

@section('title', 'Acceso | FitApp')

@section('content')
<div class="section-pad">
    <div class="mb-4 pt-2">
        <a href="{{ route('fitapp.splash') }}" class="text-decoration-none text-dark">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
    </div>

    <div class="mb-4">
        <h1 class="fit-title mb-2">Bienvenido a FitCoach</h1>
        <p class="fit-subtitle mb-0">
            Inicia sesión o crea tu cuenta para comenzar tu plan.
        </p>
    </div>

    <ul class="nav nav-pills mb-4" id="authTabs" role="tablist">
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link active w-100 rounded-pill" id="login-tab" data-bs-toggle="pill" data-bs-target="#login-pane" type="button">
                Iniciar sesión
            </button>
        </li>
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link w-100 rounded-pill" id="register-tab" data-bs-toggle="pill" data-bs-target="#register-pane" type="button">
                Crear cuenta
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="login-pane">
            <div class="mb-3">
                <label class="form-label fw-semibold">Correo</label>
                <input type="email" class="form-control input-soft" placeholder="correo@ejemplo.com">
            </div>

            <div class="mb-2">
                <label class="form-label fw-semibold">Contraseña</label>
                <input type="password" class="form-control input-soft" placeholder="********">
            </div>

            <div class="text-end mb-4">
                <a href="#" class="small text-decoration-none text-primary-custom">Olvidé mi contraseña</a>
            </div>

            <a href="{{ route('fitapp.onboarding') }}" class="btn btn-primary-custom w-100">
                Entrar
            </a>
        </div>

        <div class="tab-pane fade" id="register-pane">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre completo</label>
                <input type="text" class="form-control input-soft" placeholder="Tu nombre">
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label fw-semibold">Edad</label>
                    <input type="text" class="form-control input-soft" placeholder="25">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label fw-semibold">Sexo</label>
                    <select class="form-select input-soft">
                        <option>Selecciona</option>
                        <option>Hombre</option>
                        <option>Mujer</option>
                        <option>Otro</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label fw-semibold">Peso</label>
                    <input type="text" class="form-control input-soft" placeholder="70 kg">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label fw-semibold">Estatura</label>
                    <input type="text" class="form-control input-soft" placeholder="1.70 m">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Teléfono</label>
                <input type="text" class="form-control input-soft" placeholder="55 0000 0000">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Correo</label>
                <input type="email" class="form-control input-soft" placeholder="correo@ejemplo.com">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Contraseña</label>
                <input type="password" class="form-control input-soft" placeholder="********">
            </div>

            <a href="{{ route('fitapp.onboarding') }}" class="btn btn-primary-custom w-100">
                Crear cuenta
            </a>
        </div>
    </div>
</div>
@endsection
