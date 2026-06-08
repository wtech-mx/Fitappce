@extends('layouts.fitapp')

@section('title', 'Perfil | FitApp')

@section('content')
@php
    $activeVisual = $user->body_visual_type ?? 'avatar';
    $latestMeasurement = $user->measurements()->latest('measured_at')->latest()->first();
    $weight = $latestMeasurement?->weight ?? $user->initial_weight;
    $genderClass = $user->gender === 'Femenino' ? 'gender-female' : 'gender-male';
@endphp

<div class="section-pad">
    <div class="d-flex flex-column align-items-center text-center mb-4 pt-3">
        <div class="avatar-xl mb-3">{{ $user->initials() }}</div>
        <h1 class="fit-title mb-1">{{ $user->name }}</h1>
        <p class="fit-subtitle mb-0">{{ $user->plan_type ?: 'Plan personalizado' }} - {{ $user->goal ?: 'Progreso fitness' }}</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success rounded-4">{{ session('status') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="profile-stat">
                <div class="value">{{ $weight ? number_format((float) $weight, 1) : '-' }}</div>
                <div class="label">Kg</div>
            </div>
        </div>
        <div class="col-4">
            <div class="profile-stat">
                <div class="value">{{ $user->age ?: '-' }}</div>
                <div class="label">Edad</div>
            </div>
        </div>
        <div class="col-4">
            <div class="profile-stat">
                <div class="value">{{ $user->training_days ?: '-' }}</div>
                <div class="label">Dias/sem</div>
            </div>
        </div>
    </div>

    <div class="surface-card p-4 mb-3">
        <div class="fw-bold mb-3">Mi configuracion</div>

        <div class="d-flex justify-content-between align-items-center py-2 gap-3">
            <span>Objetivo actual</span>
            <span class="text-muted text-end">{{ $user->goal ?: 'Sin objetivo' }}</span>
        </div>

        <div class="soft-divider"></div>

        <div class="d-flex justify-content-between align-items-center py-2 gap-3">
            <span>Servicio contratado</span>
            <span class="text-muted text-end">{{ $user->service ?: 'Sin servicio' }}</span>
        </div>

        <div class="soft-divider"></div>

        <div class="d-flex justify-content-between align-items-center py-2 gap-3">
            <span>Tipo de plan</span>
            <span class="text-muted text-end">{{ $user->plan_type ?: 'Personalizado' }}</span>
        </div>

        <div class="soft-divider"></div>

        <div class="d-flex justify-content-between align-items-center py-2 gap-3">
            <span>Lugar de entrenamiento</span>
            <span class="text-muted text-end">{{ $user->training_place ?: 'Por definir' }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('fitapp.perfil.visual') }}" class="surface-card p-4 mb-3">
        @csrf
        @method('PUT')

        <div class="section-title-row mb-3">
            <div>
                <div class="fw-bold">Visual de progreso</div>
                <div class="fit-subtitle">Elige como quieres ver tu comparativa corporal.</div>
            </div>
        </div>

        @error('body_visual_type')
            <div class="alert alert-danger rounded-4 py-2">{{ $message }}</div>
        @enderror

        <div class="profile-visual-grid">
            @foreach($bodyVisualTypes as $key => $visual)
                <label class="profile-visual-option {{ $activeVisual === $key ? 'active' : '' }}">
                    <input type="radio" name="body_visual_type" value="{{ $key }}" @checked($activeVisual === $key)>
                    <span class="profile-visual-preview">
                        @if($key === 'avatar')
                            <span class="body-avatar-figure is-preview" aria-hidden="true"></span>
                        @else
                            <span class="mini-human visual-{{ $key }} {{ $genderClass }} morph-athletic is-current is-lean" aria-hidden="true">
                                <span class="mini-human-head"></span>
                                <span class="mini-human-neck"></span>
                                <span class="mini-human-body"></span>
                                <span class="mini-human-chest"></span>
                                <span class="mini-human-waist"></span>
                                <span class="mini-human-hips"></span>
                                <span class="mini-human-arm left"></span>
                                <span class="mini-human-arm right"></span>
                                <span class="mini-human-leg left"></span>
                                <span class="mini-human-leg right"></span>
                                <span class="mini-human-calf left"></span>
                                <span class="mini-human-calf right"></span>
                            </span>
                        @endif
                    </span>
                    <span class="profile-visual-copy">
                        <strong>{{ $visual['label'] }}</strong>
                        <small>{{ $visual['description'] }}</small>
                    </span>
                </label>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mt-3">Guardar visual</button>
    </form>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Acciones</div>

        <a href="{{ route('fitapp.plan') }}" class="btn btn-soft-custom w-100 mb-2">Ver plan alimentario</a>
        <a href="{{ route('fitapp.recetas') }}" class="btn btn-soft-custom w-100 mb-2">Ver recetas</a>
        <a href="{{ route('fitapp.logros') }}" class="btn btn-soft-custom w-100 mb-2">Ver vitrina de logros</a>
        <a href="{{ route('fitapp.progreso') }}" class="btn btn-soft-custom w-100 mb-2">Ver progreso</a>
        <a href="{{ route('fitapp.progreso-corporal') }}" class="btn btn-primary-custom w-100">Ver reporte corporal</a>
    </div>

    <form method="POST" action="{{ route('fitapp.logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100 rounded-4">
        Cerrar sesion
        </button>
    </form>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
