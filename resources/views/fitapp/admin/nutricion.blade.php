@extends('layouts.fitapp-admin')

@section('title', 'Nutricion | FitCoach Admin')

@section('content')
@php
    $plans = [
        [
            'name' => 'Adrian 2168 Kcal',
            'user' => 'Adrian',
            'date' => '18-04-2026',
            'kcal' => '2168',
            'protein' => '143.98 g',
            'carbs' => '266.35 g',
            'fat' => '64.25 g',
            'status' => 'Activo',
        ],
        [
            'name' => 'Maria Definicion 1800 Kcal',
            'user' => 'Maria Gonzalez',
            'date' => '12-04-2026',
            'kcal' => '1800',
            'protein' => '135 g',
            'carbs' => '190 g',
            'fat' => '52 g',
            'status' => 'Revision',
        ],
        [
            'name' => 'Base masa muscular 2400 Kcal',
            'user' => 'Plantilla',
            'date' => '10-04-2026',
            'kcal' => '2400',
            'protein' => '165 g',
            'carbs' => '310 g',
            'fat' => '70 g',
            'status' => 'Plantilla',
        ],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-journal-medical me-2 text-primary-custom"></i>Nutricion</h1>
        <div class="admin-topbar-subtitle">Indice de planes nutricionales, plantillas y registros asignados a usuarios.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.nutricion.crear') }}" class="btn btn-primary-custom px-4">
            <i class="bi bi-plus-circle me-1"></i> Nuevo plan
        </a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-journal-check me-1 text-primary-custom"></i>Planes activos</div>
        <div class="admin-stat-value">18</div>
        <div class="admin-stat-note">Usuarios con nutricion asignada</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-boxes me-1 text-primary-custom"></i>Plantillas</div>
        <div class="admin-stat-value">7</div>
        <div class="admin-stat-note">Bases reutilizables</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-pencil-square me-1 text-primary-custom"></i>En revision</div>
        <div class="admin-stat-value">4</div>
        <div class="admin-stat-note">Ajuste por progreso mensual</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-egg-fried me-1 text-primary-custom"></i>Catalogo</div>
        <div class="admin-stat-value">126</div>
        <div class="admin-stat-note">Alimentos registrados</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active"><i class="bi bi-grid me-1"></i>Todos</span>
    <span class="admin-filter-chip"><i class="bi bi-person-check me-1"></i>Asignados</span>
    <span class="admin-filter-chip"><i class="bi bi-box me-1"></i>Plantillas</span>
    <span class="admin-filter-chip"><i class="bi bi-arrow-repeat me-1"></i>Revision</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar plan, usuario o kcal...">
    </div>
</div>

<div class="admin-panel mb-4">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title"><i class="bi bi-boxes me-2 text-primary-custom"></i>Catalogos base</h2>
        <span class="small text-muted"><i class="bi bi-info-circle me-1"></i>Lo que alimenta el constructor</span>
    </div>

    <div class="admin-panel-body">
        <div class="admin-flow-list">
            <div class="admin-flow-item">
                <div class="admin-flow-icon"><i class="bi bi-lightning-charge"></i></div>
                <div>
                    <div class="fw-bold">Proteinas</div>
                    <div class="admin-mini">Carnes, pescados, huevo, lacteos, suplementos.</div>
                </div>
            </div>
            <div class="admin-flow-item">
                <div class="admin-flow-icon"><i class="bi bi-bar-chart"></i></div>
                <div>
                    <div class="fw-bold">Carbohidratos</div>
                    <div class="admin-mini">Cereales, tuberculos, leguminosas y frutas.</div>
                </div>
            </div>
            <div class="admin-flow-item">
                <div class="admin-flow-icon"><i class="bi bi-droplet-half"></i></div>
                <div>
                    <div class="fw-bold">Grasas</div>
                    <div class="admin-mini">Aceites, semillas, aguacate y frutos secos.</div>
                </div>
            </div>
        </div>

        <div class="admin-helper-note mt-3">
            <div class="fw-bold mb-1"><i class="bi bi-signpost-split me-1 text-primary-custom"></i>Estructura recomendada</div>
            <div class="admin-mini">
                Este index lista planes. El armado desde cero vive en Nuevo plan, donde seleccionaremos alimentos del catalogo y calcularemos macros por comida.
            </div>
        </div>
    </div>
</div>

<div class="admin-panel">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title"><i class="bi bi-list-check me-2 text-primary-custom"></i>Planes nutricionales</h2>
        <span class="small text-muted">Vista index</span>
    </div>

    <div class="admin-panel-body">
        <div class="admin-card-grid">
            @foreach($plans as $plan)
                <div class="admin-plan-card">
                    <div class="admin-card-body">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <div class="admin-card-title">{{ $plan['name'] }}</div>
                                <div class="admin-card-text">{{ $plan['user'] }} - {{ $plan['date'] }}</div>
                            </div>
                            <span class="admin-tag {{ $plan['status'] === 'Activo' ? 'blue' : 'yellow' }}">{{ $plan['status'] }}</span>
                        </div>

                        <div class="routine-summary-grid mb-3">
                            <div><span><i class="bi bi-fire me-1"></i>Kcal</span><strong>{{ $plan['kcal'] }}</strong></div>
                            <div><span><i class="bi bi-lightning-charge me-1"></i>Proteina</span><strong>{{ $plan['protein'] }}</strong></div>
                            <div><span><i class="bi bi-bar-chart me-1"></i>Hidratos</span><strong>{{ $plan['carbs'] }}</strong></div>
                            <div><span><i class="bi bi-droplet-half me-1"></i>Grasas</span><strong>{{ $plan['fat'] }}</strong></div>
                        </div>

                        <div class="admin-card-actions">
                            <a href="{{ route('fitapp.admin.nutricion.crear') }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                            <a href="{{ route('fitapp.plan') }}" class="admin-btn-soft"><i class="bi bi-phone"></i> Vista usuario</a>
                            <a href="{{ route('fitapp.admin.usuarios.detalle') }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Usuario</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
