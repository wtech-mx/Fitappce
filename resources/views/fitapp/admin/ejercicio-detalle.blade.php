@extends('layouts.fitapp-admin')

@section('title', 'Detalle de ejercicio | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $exercise->name }}</h1>
        <div class="admin-topbar-subtitle">{{ $exercise->taxonomyLabel() ?: 'Ejercicio del catalogo' }}</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.admin.ejercicios.edit', $exercise) }}" class="btn btn-primary-custom px-4">Editar</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Informacion tecnica</h2>
                <div class="admin-mini">Texto que vera el cliente al abrir el ejercicio.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-detail-tags mb-3">
                    @if($exercise->parent_category)<span class="admin-tag">{{ $exercise->parent_category }}</span>@endif
                    @if($exercise->category)<span class="admin-tag">{{ $exercise->category }}</span>@endif
                    @if($exercise->subcategory)<span class="admin-tag blue">{{ $exercise->subcategory }}</span>@endif
                    @if($exercise->level)<span class="admin-tag yellow">{{ $exercise->level }}</span>@endif
                </div>

                <div class="routine-purpose-box mb-3">
                    <div class="admin-mini mb-1">Descripcion</div>
                    <div class="fw-bold">{{ $exercise->description ?: 'Sin descripcion.' }}</div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="profile-stat">
                            <div class="value">{{ $exercise->primary_muscle ?: '-' }}</div>
                            <div class="label">Musculo principal</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-stat">
                            <div class="value">{{ $exercise->allows_evidence ? 'Si' : 'No' }}</div>
                            <div class="label">Permite evidencia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Indicaciones</h2>
                <div class="admin-mini">Contenido para rutina del usuario.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="fw-bold mb-2">Para que sirve</div>
                <div class="admin-text-block mb-3">{{ $exercise->purpose ?: 'Sin texto capturado.' }}</div>

                <div class="fw-bold mb-2">Notas del coach</div>
                <div class="admin-text-block mb-3">{{ $exercise->coach_notes ?: 'Sin notas capturadas.' }}</div>

                <div class="fw-bold mb-2">Errores comunes</div>
                <div class="admin-text-block">{{ $exercise->common_mistakes ?: 'Sin errores capturados.' }}</div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Demo</h2>
                <div class="admin-mini">{{ strtoupper($exercise->demo_type) }} - {{ $exercise->demo_source === 'url' ? 'URL externa' : 'Archivo subido' }}</div>
            </div>
            <div class="admin-form-card-body">
                <div class="exercise-demo-preview">
                    @include('fitapp.partials.exercise-demo', [
                        'exercise' => $exercise,
                        'emptyTitle' => 'Sin demo cargado',
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
