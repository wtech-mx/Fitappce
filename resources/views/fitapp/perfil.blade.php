@extends('layouts.fitapp')

@section('title', 'Perfil | FitApp')

@section('content')
<div class="section-pad">
    <div class="d-flex flex-column align-items-center text-center mb-4 pt-3">
        <div class="avatar-xl mb-3">C</div>
        <h1 class="fit-title mb-1">Carlos Mendoza</h1>
        <p class="fit-subtitle mb-0">Plan personalizado · Masa muscular</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="profile-stat">
                <div class="value">72</div>
                <div class="label">Kg</div>
            </div>
        </div>
        <div class="col-4">
            <div class="profile-stat">
                <div class="value">1.74</div>
                <div class="label">Altura</div>
            </div>
        </div>
        <div class="col-4">
            <div class="profile-stat">
                <div class="value">3</div>
                <div class="label">Días/sem</div>
            </div>
        </div>
    </div>

    <div class="surface-card p-4 mb-3">
        <div class="fw-bold mb-3">Mi configuración</div>

        <div class="d-flex justify-content-between align-items-center py-2">
            <span>Objetivo actual</span>
            <span class="text-muted">Masa muscular</span>
        </div>

        <div class="soft-divider"></div>

        <div class="d-flex justify-content-between align-items-center py-2">
            <span>Servicio contratado</span>
            <span class="text-muted">Rutina + nutrición</span>
        </div>

        <div class="soft-divider"></div>

        <div class="d-flex justify-content-between align-items-center py-2">
            <span>Tipo de plan</span>
            <span class="text-muted">Personalizado</span>
        </div>

        <div class="soft-divider"></div>

        <div class="d-flex justify-content-between align-items-center py-2">
            <span>Lugar de entrenamiento</span>
            <span class="text-muted">Gimnasio</span>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Acciones</div>

        <a href="{{ route('fitapp.plan') }}" class="btn btn-soft-custom w-100 mb-2">Ver plan alimentario</a>
        <a href="{{ route('fitapp.recetas') }}" class="btn btn-soft-custom w-100 mb-2">Ver recetas</a>
        <a href="{{ route('fitapp.progreso') }}" class="btn btn-soft-custom w-100 mb-2">Ver progreso</a>
        <button class="btn btn-primary-custom w-100">Editar perfil</button>
    </div>

    <a href="{{ route('fitapp.auth') }}" class="btn btn-outline-danger w-100 rounded-4">
        Cerrar sesión
    </a>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
