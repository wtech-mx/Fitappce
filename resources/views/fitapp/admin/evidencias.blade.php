@extends('layouts.fitapp-admin')

@section('title', 'Evidencias | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Evidencias</h1>
        <div class="admin-topbar-subtitle">Videos por ejercicio y fotos de comida enviadas por los usuarios.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="admin-icon-btn" type="button">
            <i class="bi bi-funnel"></i>
        </button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todas</span>
    <span class="admin-filter-chip">Videos</span>
    <span class="admin-filter-chip">Fotos comida</span>
    <span class="admin-filter-chip">Pendientes</span>
    <span class="admin-filter-chip">Revisadas</span>
</div>

<div class="admin-card-grid">
    <div class="admin-evidence-card">
        <div class="admin-card-cover"></div>
        <div class="admin-card-body">
            <div class="admin-card-title">Sentadilla Goblet</div>
            <div class="admin-card-text mb-2">María González · Video de evidencia</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag yellow">Pendiente revisión</span>
                <span class="admin-tag">Rutina Lunes</span>
            </div>
            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-play-circle"></i> Ver video</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-check2-circle"></i> Calificar</a>
            </div>
        </div>
    </div>

    <div class="admin-evidence-card">
        <div class="admin-card-cover"></div>
        <div class="admin-card-body">
            <div class="admin-card-title">Hip Thrust</div>
            <div class="admin-card-text mb-2">Alan Pérez · Video de evidencia</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag blue">Revisada</span>
                <span class="admin-tag">Glúteo</span>
            </div>
            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-play-circle"></i> Ver video</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-chat-left-text"></i> Feedback</a>
            </div>
        </div>
    </div>

    <div class="admin-evidence-card">
        <div class="admin-card-cover"></div>
        <div class="admin-card-body">
            <div class="admin-card-title">Foto de comida</div>
            <div class="admin-card-text mb-2">Fernanda Ruiz · Almuerzo</div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag yellow">Pendiente</span>
                <span class="admin-tag">Nutrición</span>
            </div>
            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-image"></i> Ver foto</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-pencil-square"></i> Evaluar</a>
            </div>
        </div>
    </div>
</div>
@endsection
