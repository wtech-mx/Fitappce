@extends('layouts.fitapp-admin')

@section('title', 'Detalle de ejercicio | FitCoach Admin')

@section('content')
@php
    $statusLabel = $exercise->is_active ? 'Activo' : 'Oculto';
    $sourceLabel = $exercise->demo_source === 'url' ? 'URL externa' : 'Archivo subido';
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $exercise->name }}</h1>
        <div class="admin-topbar-subtitle">{{ $exercise->taxonomyLabel() ?: 'Ejercicio del catalogo' }}</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios') }}" class="btn btn-soft-custom px-4 admin-action-btn">
            <i class="bi bi-arrow-left"></i>
            <span>Volver</span>
        </a>
        <a href="{{ route('fitapp.admin.ejercicios.edit', $exercise) }}" class="btn btn-primary-custom px-4 admin-action-btn">
            <i class="bi bi-pencil-square"></i>
            <span>Editar</span>
        </a>
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
                <div class="admin-section-heading">
                    <div class="admin-section-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Informacion tecnica</h2>
                        <div class="admin-mini">Texto que vera el cliente al abrir el ejercicio.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-detail-tags mb-3">
                    @if($exercise->parent_category)<span class="admin-tag">{{ $exercise->parent_category }}</span>@endif
                    @if($exercise->category)<span class="admin-tag">{{ $exercise->category }}</span>@endif
                    @if($exercise->subcategory)<span class="admin-tag blue">{{ $exercise->subcategory }}</span>@endif
                    @if($exercise->level)<span class="admin-tag yellow">{{ $exercise->level }}</span>@endif
                    <span class="admin-tag {{ $exercise->is_active ? 'blue' : 'yellow' }}">{{ $statusLabel }}</span>
                </div>

                <div class="routine-purpose-box mb-3">
                    <div class="admin-mini mb-1"><i class="bi bi-card-text me-1"></i>Descripcion</div>
                    <div class="exercise-rich-content">{!! $exercise->description ?: '<p>Sin descripcion.</p>' !!}</div>
                </div>

                <div class="exercise-detail-stat-grid">
                    <div class="exercise-detail-stat">
                        <i class="bi bi-bullseye"></i>
                        <div>
                            <span>Musculo principal</span>
                            <strong>{{ $exercise->primary_muscle ?: '-' }}</strong>
                        </div>
                    </div>
                    <div class="exercise-detail-stat">
                        <i class="bi bi-person-arms-up"></i>
                        <div>
                            <span>Musculos</span>
                            <strong>{{ $exercise->muscles ?: '-' }}</strong>
                        </div>
                    </div>
                    <div class="exercise-detail-stat">
                        <i class="bi bi-camera-video"></i>
                        <div>
                            <span>Permite evidencia</span>
                            <strong>{{ $exercise->allows_evidence ? 'Si' : 'No' }}</strong>
                        </div>
                    </div>
                    <div class="exercise-detail-stat">
                        <i class="bi bi-star"></i>
                        <div>
                            <span>Destacado</span>
                            <strong>{{ $exercise->is_featured ? 'Si' : 'No' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon success"><i class="bi bi-chat-square-heart"></i></div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Indicaciones</h2>
                        <div class="admin-mini">Contenido para rutina del usuario.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="fw-bold mb-2 admin-label-icon"><i class="bi bi-lightbulb"></i> Para que sirve</div>
                <div class="admin-text-block exercise-rich-content mb-3">{!! $exercise->purpose ?: '<p>Sin texto capturado.</p>' !!}</div>

                <div class="fw-bold mb-2 admin-label-icon"><i class="bi bi-megaphone"></i> Notas del coach</div>
                <div class="admin-text-block exercise-rich-content mb-3">{!! $exercise->coach_notes ?: '<p>Sin notas capturadas.</p>' !!}</div>

                <div class="fw-bold mb-2 admin-label-icon"><i class="bi bi-exclamation-triangle"></i> Errores comunes</div>
                <div class="admin-text-block exercise-rich-content">{!! $exercise->common_mistakes ?: '<p>Sin errores capturados.</p>' !!}</div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon accent"><i class="bi bi-play-btn"></i></div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Demo</h2>
                        <div class="admin-mini">{{ strtoupper($exercise->demo_type) }} - {{ $sourceLabel }}</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="exercise-demo-preview mb-3">
                    @include('fitapp.partials.exercise-demo', [
                        'exercise' => $exercise,
                        'emptyTitle' => 'Sin demo cargado',
                    ])
                </div>

                <div class="exercise-detail-meta">
                    <div><i class="bi bi-file-play"></i><span>Tipo</span><strong>{{ strtoupper($exercise->demo_type) }}</strong></div>
                    <div><i class="bi bi-hdd-network"></i><span>Origen</span><strong>{{ $sourceLabel }}</strong></div>
                    <div><i class="bi bi-toggle-on"></i><span>Estado</span><strong>{{ $statusLabel }}</strong></div>
                </div>

                <a href="{{ route('fitapp.admin.ejercicios.edit', $exercise) }}" class="btn btn-primary-custom w-100 mt-3 admin-action-btn justify-content-center">
                    <i class="bi bi-pencil-square"></i>
                    <span>Editar ejercicio</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
