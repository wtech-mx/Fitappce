@extends('layouts.fitapp-admin')

@section('title', 'Nutricion | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-journal-medical me-2 text-primary-custom"></i>Nutricion</h1>
        <div class="admin-topbar-subtitle">Planes alimentarios reales asignados a clientes.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.nutricion.crear') }}" class="btn btn-primary-custom px-4">
            <i class="bi bi-plus-circle me-1"></i> Nuevo plan
        </a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-journal-check me-1 text-primary-custom"></i>Planes activos</div>
        <div class="admin-stat-value">{{ $plans->where('status', 'active')->count() }}</div>
        <div class="admin-stat-note">Asignados a clientes</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-boxes me-1 text-primary-custom"></i>Total planes</div>
        <div class="admin-stat-value">{{ $plans->count() }}</div>
        <div class="admin-stat-note">Historial nutricional</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-pencil-square me-1 text-primary-custom"></i>Borradores</div>
        <div class="admin-stat-value">{{ $plans->where('status', 'draft')->count() }}</div>
        <div class="admin-stat-note">Pendientes de activar</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-egg-fried me-1 text-primary-custom"></i>Comidas</div>
        <div class="admin-stat-value">{{ $plans->sum(fn ($plan) => $plan->meals->count()) }}</div>
        <div class="admin-stat-note">Bloques capturados</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active"><i class="bi bi-grid me-1"></i>Todos</span>
    <form method="GET" action="{{ route('fitapp.admin.nutricion') }}" class="ms-auto admin-search">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar plan, usuario o kcal...">
    </form>
</div>

<div class="admin-panel">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title"><i class="bi bi-list-check me-2 text-primary-custom"></i>Planes nutricionales</h2>
        <span class="small text-muted">Datos reales</span>
    </div>

    <div class="admin-panel-body">
        @if ($plans->isEmpty())
            <div class="admin-helper-note">
                <div class="fw-bold mb-1">Sin planes alimentarios</div>
                <div class="admin-mini mb-3">Crea el primer plan para asignarlo a un cliente y mostrarlo en su app.</div>
                <a href="{{ route('fitapp.admin.nutricion.crear') }}" class="btn btn-primary-custom">Nuevo plan</a>
            </div>
        @else
            <div class="admin-card-grid">
                @foreach($plans as $plan)
                    @php $totals = $plan->macroTotals(); @endphp
                    <div class="admin-plan-card">
                        <div class="admin-card-body">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <div class="admin-card-title">{{ $plan->name }}</div>
                                    <div class="admin-card-text">{{ $plan->user?->name ?: 'Sin usuario' }} - {{ $plan->plan_date ? $plan->plan_date : 'Sin fecha' }}</div>
                                </div>
                                <span class="admin-tag {{ $plan->status === 'active' ? 'blue' : 'yellow' }}">{{ ucfirst($plan->status) }}</span>
                            </div>

                            <div class="routine-summary-grid mb-3">
                                <div><span><i class="bi bi-fire me-1"></i>Kcal</span><strong>{{ number_format($totals['calories'], 0) }}</strong></div>
                                <div><span><i class="bi bi-lightning-charge me-1"></i>Proteina</span><strong>{{ number_format($totals['protein'], 1) }}g</strong></div>
                                <div><span><i class="bi bi-bar-chart me-1"></i>Hidratos</span><strong>{{ number_format($totals['carbohydrates'], 1) }}g</strong></div>
                                <div><span><i class="bi bi-droplet-half me-1"></i>Grasas</span><strong>{{ number_format($totals['fat'], 1) }}g</strong></div>
                            </div>

                            <div class="admin-card-text mb-3">
                                {{ $plan->meals->count() }} comidas - {{ $plan->foodItemsCount() }} alimentos - Agua: {{ $plan->daily_water ?: 'Pendiente' }}
                            </div>

                            <div class="admin-card-actions">
                                <a href="{{ route('fitapp.admin.nutricion.show', $plan) }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver nutricion</a>
                                <a href="{{ route('fitapp.admin.nutricion.edit', $plan) }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                                <a href="{{ route('fitapp.admin.nutricion.crear', ['user' => $plan->user_id]) }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Nuevo para usuario</a>
                                <a href="{{ route('fitapp.plan') }}" class="admin-btn-soft"><i class="bi bi-phone"></i> Vista usuario</a>
                                @if ($plan->user)
                                    <a href="{{ route('fitapp.admin.usuarios.detalle', $plan->user) }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Usuario</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
