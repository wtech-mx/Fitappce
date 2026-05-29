@extends('layouts.fitapp-admin')

@section('title', 'Detalle nutricion | FitCoach Admin')

@section('content')
@php
    $totals = $plan->macroTotals();
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-journal-medical me-2 text-primary-custom"></i>{{ $plan->name }}</h1>
        <div class="admin-topbar-subtitle">
            {{ $plan->user?->name ?: 'Sin usuario' }} - {{ $plan->plan_date ?: 'Sin fecha' }}
        </div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.planes', $plan->user ? ['user' => $plan->user_id] : []) }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Planes</a>
        <a href="{{ route('fitapp.admin.nutricion.edit', $plan) }}" class="btn btn-primary-custom px-4"><i class="bi bi-pencil me-1"></i> Editar plan</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Kcal reales</div>
        <div class="admin-stat-value">{{ number_format($totals['calories'], 0) }}</div>
        <div class="admin-stat-note">Suma de alimentos</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Proteina</div>
        <div class="admin-stat-value">{{ number_format($totals['protein'], 1) }}g</div>
        <div class="admin-stat-note">Total diario</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Carbs</div>
        <div class="admin-stat-value">{{ number_format($totals['carbohydrates'], 1) }}g</div>
        <div class="admin-stat-note">Total diario</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Grasas</div>
        <div class="admin-stat-value">{{ number_format($totals['fat'], 1) }}g</div>
        <div class="admin-stat-note">Total diario</div>
    </div>
</div>

<div class="admin-panel mb-4">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title">Resumen del plan</h2>
        <span class="admin-tag {{ $plan->status === 'active' ? 'blue' : 'yellow' }}">{{ $plan->status === 'active' ? 'Activo' : ucfirst($plan->status) }}</span>
    </div>
    <div class="admin-panel-body">
        <div class="routine-purpose-box mb-3">
            <div class="admin-mini mb-1">Objetivo</div>
            <div class="fw-bold">{{ $plan->goal ?: 'Sin objetivo capturado' }}</div>
            <div class="admin-card-text mt-1">Agua diaria: {{ $plan->daily_water ?: 'Pendiente' }}</div>
        </div>
        <div class="admin-card-text">{{ $plan->notes ?: 'Sin notas del coach para este plan.' }}</div>
    </div>
</div>

<div class="admin-section-stack">
    @foreach($plan->meals as $meal)
        @php
            $mealTotals = [
                'calories' => (float) $meal->items->sum('calories'),
                'protein' => (float) $meal->items->sum('protein'),
                'carbohydrates' => (float) $meal->items->sum('carbohydrates'),
                'fat' => (float) $meal->items->sum('fat'),
            ];
        @endphp
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div>
                    <h2 class="admin-panel-title mb-1">{{ $meal->name }}</h2>
                    <div class="admin-mini">
                        {{ number_format($mealTotals['calories'], 0) }} kcal -
                        {{ number_format($mealTotals['protein'], 1) }}g proteina -
                        {{ number_format($mealTotals['carbohydrates'], 1) }}g carbs -
                        {{ number_format($mealTotals['fat'], 1) }}g grasas
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                @if($meal->items->isEmpty())
                    <div class="admin-helper-note mb-0">Esta comida no tiene alimentos capturados.</div>
                @else
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Alimento</th>
                                    <th>Cantidad</th>
                                    <th>Kcal</th>
                                    <th>Proteina</th>
                                    <th>Carbs</th>
                                    <th>Grasas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meal->items as $item)
                                    <tr>
                                        <td>{{ $item->food_name }}</td>
                                        <td>{{ number_format((float) $item->quantity, 2) }} {{ $item->unit }}</td>
                                        <td>{{ number_format((float) $item->calories, 0) }}</td>
                                        <td>{{ number_format((float) $item->protein, 1) }}g</td>
                                        <td>{{ number_format((float) $item->carbohydrates, 1) }}g</td>
                                        <td>{{ number_format((float) $item->fat, 1) }}g</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
