@extends('layouts.fitapp')

@section('title', 'Reporte corporal | FitApp')

@section('content')
@php
    $metrics = [
        ['label' => 'Grasa corporal', 'before' => '15.46%', 'current' => '14.73%', 'change' => '-0.73%', 'tone' => 'good'],
        ['label' => 'Masa magra', 'before' => '55.20 kg', 'current' => '55.68 kg', 'change' => '+0.48 kg', 'tone' => 'good'],
        ['label' => 'Masa grasa', 'before' => '10.10 kg', 'current' => '9.62 kg', 'change' => '-0.48 kg', 'tone' => 'good'],
        ['label' => 'Peso corporal', 'before' => '65.30 kg', 'current' => '65.30 kg', 'change' => '0.00 kg', 'tone' => 'neutral'],
    ];

    $bodyZones = [
        ['name' => 'Brazo flex.', 'value' => '33.80 cm', 'change' => '+0.70', 'class' => 'zone-arm-left'],
        ['name' => 'Torax', 'value' => '97.00 cm', 'change' => '+1.20', 'class' => 'zone-chest'],
        ['name' => 'Cintura', 'value' => '81.20 cm', 'change' => '-1.80', 'class' => 'zone-waist'],
        ['name' => 'Cadera', 'value' => '92.50 cm', 'change' => '+0.80', 'class' => 'zone-hip'],
        ['name' => 'Muslo', 'value' => '56.10 cm', 'change' => '+0.60', 'class' => 'zone-leg-left'],
        ['name' => 'Pantorrilla', 'value' => '36.20 cm', 'change' => '+0.30', 'class' => 'zone-calf-right'],
    ];

    $history = [
        ['month' => 'Ene', 'fat' => 72, 'muscle' => 44, 'weight' => '66.8 kg', 'waist' => '84.0 cm'],
        ['month' => 'Feb', 'fat' => 62, 'muscle' => 52, 'weight' => '66.1 kg', 'waist' => '83.0 cm'],
        ['month' => 'Mar', 'fat' => 54, 'muscle' => 58, 'weight' => '65.3 kg', 'waist' => '82.1 cm'],
        ['month' => 'Abr', 'fat' => 46, 'muscle' => 66, 'weight' => '65.3 kg', 'waist' => '81.2 cm'],
    ];

    $monthlyChanges = [
        ['label' => 'Grasa corporal', 'start' => '16.80%', 'current' => '14.73%', 'total' => '-2.07%', 'result' => 'Bajo constante'],
        ['label' => 'Masa magra', 'start' => '54.40 kg', 'current' => '55.68 kg', 'total' => '+1.28 kg', 'result' => 'Subio'],
        ['label' => 'Cintura', 'start' => '84.00 cm', 'current' => '81.20 cm', 'total' => '-2.80 cm', 'result' => 'Redujo'],
        ['label' => 'Peso', 'start' => '66.80 kg', 'current' => '65.30 kg', 'total' => '-1.50 kg', 'result' => 'Controlado'],
    ];
@endphp

<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.progreso') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">15 Abr 2026</span>
    </div>

    <div class="body-report-hero mb-4">
        <div class="page-kicker text-white">
            <i class="bi bi-stars"></i> Resultados del mes
        </div>
        <h1 class="fit-title text-white mb-2">Tu entrenamiento si se nota</h1>
        <p class="text-white-50 mb-0">
            Bajaste grasa, mantuviste peso y subiste masa magra. El cuerpo esta cambiando aunque la bascula no se mueva.
        </p>
    </div>

    <div class="body-report-score mb-4">
        <div>
            <div class="body-score-label">Lectura del coach</div>
            <div class="body-score-title">Progreso positivo</div>
            <div class="fit-subtitle">Comparado contra tu medicion anterior.</div>
        </div>
        <div class="body-score-ring">
            <span>86</span>
            <small>/100</small>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach($metrics as $metric)
            <div class="col-6">
                <div class="body-metric-card {{ $metric['tone'] === 'good' ? 'is-good' : '' }}">
                    <div class="body-metric-label">{{ $metric['label'] }}</div>
                    <div class="body-metric-value">{{ $metric['current'] }}</div>
                    <div class="body-metric-compare">
                        <span>{{ $metric['before'] }}</span>
                        <strong>{{ $metric['change'] }}</strong>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Mapa corporal</h2>
            <span class="mini-note">Medicion actual</span>
        </div>

        <div class="body-map-wrap">
            <div class="human-map" aria-label="Mapa corporal visual">
                <div class="human-scan"></div>
                <div class="human-head"></div>
                <div class="human-neck"></div>
                <div class="human-torso"></div>
                <div class="human-waist"></div>
                <div class="human-hips"></div>
                <div class="human-arm human-arm-left"></div>
                <div class="human-arm human-arm-right"></div>
                <div class="human-leg human-leg-left"></div>
                <div class="human-leg human-leg-right"></div>
                <div class="human-calf human-calf-left"></div>
                <div class="human-calf human-calf-right"></div>
                <div class="human-core-line"></div>
                <div class="measure-ring ring-chest"></div>
                <div class="measure-ring ring-waist"></div>
                <div class="measure-ring ring-hip"></div>

                @foreach($bodyZones as $zone)
                    <div class="body-zone {{ $zone['class'] }}">
                        <span>{{ $zone['name'] }}</span>
                        <strong>{{ $zone['value'] }}</strong>
                        <em>{{ $zone['change'] }}</em>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="body-map-legend">
            <span><i class="legend-dot good"></i> Mejora</span>
            <span><i class="legend-dot neutral"></i> Se mantiene</span>
            <span><i class="legend-dot warn"></i> Revisar</span>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Comparativo mensual</h2>
            <span class="mini-note">Feb - Abr</span>
        </div>

        <div class="body-chart">
            @foreach($history as $point)
                <div class="body-chart-col">
                    <div class="body-chart-bars">
                        <span class="bar-fat" style="height:{{ $point['fat'] }}%;"></span>
                        <span class="bar-muscle" style="height:{{ $point['muscle'] }}%;"></span>
                    </div>
                    <div class="body-chart-label">{{ $point['month'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="body-map-legend mt-3">
            <span><i class="legend-dot warn"></i> Grasa</span>
            <span><i class="legend-dot good"></i> Masa magra</span>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Diferencia contra otros meses</h2>
            <span class="mini-note">Ene - Abr</span>
        </div>

        <div class="body-month-track mb-3">
            @foreach($history as $index => $point)
                <div class="body-month-step {{ $loop->last ? 'active' : '' }}">
                    <span>{{ $point['month'] }}</span>
                    <strong>{{ $point['weight'] }}</strong>
                    <em>{{ $point['waist'] }}</em>
                </div>
            @endforeach
        </div>

        <div class="d-grid gap-3">
            @foreach($monthlyChanges as $change)
                <div class="month-compare-row">
                    <div>
                        <div class="fw-bold">{{ $change['label'] }}</div>
                        <div class="fit-subtitle">{{ $change['start'] }} -> {{ $change['current'] }}</div>
                    </div>
                    <div class="text-end">
                        <span class="status-pill status-ok">{{ $change['total'] }}</span>
                        <div class="small text-muted mt-1">{{ $change['result'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Que significa esto</div>

        <div class="result-insight good mb-3">
            <i class="bi bi-arrow-down-right"></i>
            <div>
                <div class="fw-bold">Bajaste grasa corporal</div>
                <div class="fit-subtitle">La grasa paso de 15.46% a 14.73%. Es una mejora clara para un mes de trabajo.</div>
            </div>
        </div>

        <div class="result-insight good mb-3">
            <i class="bi bi-arrow-up-right"></i>
            <div>
                <div class="fw-bold">Subiste masa magra</div>
                <div class="fit-subtitle">Ganaste 0.48 kg de masa magra. Esto sugiere mejor respuesta al entrenamiento.</div>
            </div>
        </div>

        <div class="result-insight neutral">
            <i class="bi bi-dash-lg"></i>
            <div>
                <div class="fw-bold">El peso se mantuvo</div>
                <div class="fit-subtitle">Aunque la bascula no cambio, tu composicion corporal si mejoro.</div>
            </div>
        </div>
    </div>

    <div class="coach-summary-card mb-4">
        <div class="fw-bold mb-2">Siguiente ajuste del coach</div>
        <p class="mb-3">
            Mantener calorias cerca de 2168 kcal, subir ligeramente intensidad en pierna y cuidar evidencia tecnica en ejercicios base.
        </p>
        <div class="d-flex flex-wrap gap-2">
            <span class="admin-tag blue">Plan continua</span>
            <span class="admin-tag">Revisar cintura</span>
            <span class="admin-tag yellow">Nueva cita en 4 semanas</span>
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
