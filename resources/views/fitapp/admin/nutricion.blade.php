@extends('layouts.fitapp-admin')

@section('title', 'Planes nutricionales | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Planes nutricionales</h1>
        <div class="admin-topbar-subtitle">Crea, asigna y revisa planes de alimentación con evidencias de comida.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-primary-custom px-4">Nuevo plan</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-card-grid">
    <div class="admin-plan-card">
        <div class="admin-card-body">
            <div class="admin-card-title">Plan Masa Muscular · 2100 kcal</div>
            <div class="admin-card-text mb-3">Alta proteína · 5 comidas · gimnasio</div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag">160g proteína</span>
                <span class="admin-tag">Carbo moderado</span>
                <span class="admin-tag blue">Activo</span>
            </div>

            <div class="admin-card-text">
                Incluye desayuno, colación, comida y cena con ingredientes prácticos y recetas sugeridas.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver plan</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-person-plus"></i> Asignar</a>
            </div>
        </div>
    </div>

    <div class="admin-plan-card">
        <div class="admin-card-body">
            <div class="admin-card-title">Plan Definición · 1800 kcal</div>
            <div class="admin-card-text mb-3">Control calórico · 4 comidas</div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag">Déficit</span>
                <span class="admin-tag">Alta saciedad</span>
                <span class="admin-tag yellow">Pendiente asignar</span>
            </div>

            <div class="admin-card-text">
                Enfocado en adherencia y comidas sencillas con foto obligatoria de comida y cena.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-images"></i> Evidencias</a>
            </div>
        </div>
    </div>

    <div class="admin-plan-card">
        <div class="admin-card-body">
            <div class="admin-card-title">Plan Adulto Mayor</div>
            <div class="admin-card-text mb-3">Comidas simples · digestión amable</div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag">Salud general</span>
                <span class="admin-tag">Baja complejidad</span>
            </div>

            <div class="admin-card-text">
                Propuesta con enfoque en facilidad de preparación, tolerancia digestiva y constancia.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-copy"></i> Duplicar</a>
            </div>
        </div>
    </div>
</div>

<div class="admin-panel mt-3">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title">Carga rápida de plan</h2>
        <span class="small text-muted">Demo visual</span>
    </div>

    <div class="admin-panel-body">
        <div class="row g-3">
            <div class="col-lg-6">
                <label class="form-label fw-bold">Nombre del plan</label>
                <input type="text" class="form-control input-soft" placeholder="Ej. Masa muscular intermedio">
            </div>
            <div class="col-lg-3">
                <label class="form-label fw-bold">Calorías</label>
                <input type="text" class="form-control input-soft" placeholder="2100">
            </div>
            <div class="col-lg-3">
                <label class="form-label fw-bold">Comidas</label>
                <input type="text" class="form-control input-soft" placeholder="5">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Descripción</label>
                <textarea class="form-control input-soft py-3" rows="4" placeholder="Resumen del plan, objetivo, restricciones, etc."></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary-custom">Guardar plan</button>
            </div>
        </div>
    </div>
</div>
@endsection
