@extends('layouts.fitapp-admin')

@section('title', 'Planes | FitCoach Admin')

@section('content')
@php
    $tabs = [
        'active' => 'Activa',
        'past' => 'Pasadas',
        'favorites' => 'Favoritas',
        'least_favorites' => 'Menos fav',
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $selectedUser ? 'Planes de '.$selectedUser->name : 'Planes' }}</h1>
        <div class="admin-topbar-subtitle">
            {{ $selectedUser ? 'Historial de planes alimentarios del cliente y plan activo actual.' : 'Planes alimentarios asignados a clientes.' }}
        </div>
    </div>

    <div class="admin-topbar-actions">
        @if ($selectedUser)
            <a href="{{ route('fitapp.admin.usuarios.detalle', $selectedUser) }}" class="btn btn-soft-custom px-4">Volver al usuario</a>
        @endif
        <a href="{{ route('fitapp.admin.nutricion.crear', $selectedUser ? ['user' => $selectedUser->id] : []) }}" class="btn btn-primary-custom px-4">Asignar nuevo plan</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Plan activo</div>
        <div class="admin-stat-value">{{ $stats['active'] }}</div>
        <div class="admin-stat-note">{{ $selectedUser ? 'Actual del cliente' : 'Activos' }}</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Planes pasados</div>
        <div class="admin-stat-value">{{ $stats['past'] }}</div>
        <div class="admin-stat-note">Archivados</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Favoritas</div>
        <div class="admin-stat-value">{{ $stats['favorites'] }}</div>
        <div class="admin-stat-note">Mejor adherencia</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Menos fav</div>
        <div class="admin-stat-value">{{ $stats['least_favorites'] }}</div>
        <div class="admin-stat-note">Baja adherencia</div>
    </div>
</div>

<div class="admin-filter-bar">
    @foreach ($tabs as $tabKey => $label)
        <a
            href="{{ route('fitapp.admin.planes', array_filter(['user' => $selectedUser?->id, 'tab' => $tabKey, 'q' => request('q')])) }}"
            class="admin-filter-chip {{ $tab === $tabKey ? 'active' : '' }}"
        >
            {{ $label }}
        </a>
    @endforeach

    <form method="GET" action="{{ route('fitapp.admin.planes') }}" class="ms-auto admin-search">
        @if ($selectedUser)
            <input type="hidden" name="user" value="{{ $selectedUser->id }}">
        @endif
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar plan, usuario u objetivo...">
    </form>
</div>

@if ($plans->isEmpty())
    <div class="admin-helper-note">
        <div class="fw-bold mb-1">No hay planes en esta pestaña</div>
        <div class="admin-mini mb-3">
            {{ $selectedUser ? 'Puedes asignar un nuevo plan alimentario para empezar el historial del cliente.' : 'Crea planes alimentarios desde Nutricion.' }}
        </div>
        <a href="{{ route('fitapp.admin.nutricion.crear', $selectedUser ? ['user' => $selectedUser->id] : []) }}" class="btn btn-primary-custom">Asignar nuevo plan</a>
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
                            <div class="admin-card-text">
                                {{ $plan->user?->name ?: 'Sin usuario' }} · {{ $plan->plan_date ?: 'Sin fecha' }}
                            </div>
                        </div>
                        <span class="admin-tag {{ $plan->status === 'active' ? 'blue' : 'yellow' }}">
                            {{ $plan->status === 'active' ? 'Activo' : 'Pasado' }}
                        </span>
                    </div>

                    <div class="routine-purpose-box mb-3">
                        <div class="admin-mini mb-1">Objetivo</div>
                        <div class="fw-bold">{{ $plan->goal ?: 'Sin objetivo capturado' }}</div>
                        <div class="admin-card-text mt-1">{{ $plan->daily_water ? 'Agua diaria: '.$plan->daily_water : 'Agua pendiente' }}</div>
                    </div>

                    <div class="routine-summary-grid mb-3">
                        <div><span>Kcal</span><strong>{{ number_format($totals['calories'], 0) }}</strong></div>
                        <div><span>Proteina</span><strong>{{ number_format($totals['protein'], 1) }}g</strong></div>
                        <div><span>Carbs</span><strong>{{ number_format($totals['carbohydrates'], 1) }}g</strong></div>
                        <div><span>Grasas</span><strong>{{ number_format($totals['fat'], 1) }}g</strong></div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="admin-tag">{{ $plan->meals->count() }} comidas</span>
                        <span class="admin-tag blue">{{ $plan->foodItemsCount() }} alimentos</span>
                        @if ($plan->preference === 'favorite')
                            <span class="admin-tag blue">Favorita</span>
                        @elseif ($plan->preference === 'least_favorite')
                            <span class="admin-tag red">Menos fav</span>
                        @endif
                    </div>

                    <div class="admin-card-text">{{ $plan->notes ?: 'Sin notas del coach para este plan.' }}</div>

                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.nutricion.show', $plan) }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver nutricion</a>
                        @if ($plan->user)
                            <a href="{{ route('fitapp.admin.nutricion.crear', ['user' => $plan->user_id]) }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Nuevo plan</a>
                            <a href="{{ route('fitapp.admin.usuarios.detalle', $plan->user) }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Usuario</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
