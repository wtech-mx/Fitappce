@extends('layouts.fitapp')

@section('title', 'Reporte corporal | FitApp')

@section('content')
@php
    $current = $display['current'];
    $before = $display['before'];
    $latestDate = $display['latest_date'];
    $formatValue = fn ($value, string $suffix = '', int $decimals = 2) => filled($value) ? number_format((float) $value, $decimals).$suffix : '-';
    $changeValue = function ($currentValue, $beforeValue, string $suffix = '', int $decimals = 2) {
        if (! filled($currentValue) || ! filled($beforeValue)) {
            return '-';
        }

        $change = (float) $currentValue - (float) $beforeValue;
        return ($change > 0 ? '+' : '').number_format($change, $decimals).$suffix;
    };

    $metrics = [
        ['label' => 'Grasa corporal', 'before' => $formatValue($before['body_fat'], '%'), 'current' => $formatValue($current['body_fat'], '%'), 'change' => $changeValue($current['body_fat'], $before['body_fat'], '%'), 'tone' => filled($before['body_fat']) && filled($current['body_fat']) && (float) $current['body_fat'] <= (float) $before['body_fat'] ? 'good' : 'neutral'],
        ['label' => 'Masa magra', 'before' => $formatValue($before['lean_mass'], ' kg'), 'current' => $formatValue($current['lean_mass'], ' kg'), 'change' => $changeValue($current['lean_mass'], $before['lean_mass'], ' kg'), 'tone' => filled($before['lean_mass']) && filled($current['lean_mass']) && (float) $current['lean_mass'] >= (float) $before['lean_mass'] ? 'good' : 'neutral'],
        ['label' => 'Masa grasa', 'before' => $formatValue($before['fat_mass'], ' kg'), 'current' => $formatValue($current['fat_mass'], ' kg'), 'change' => $changeValue($current['fat_mass'], $before['fat_mass'], ' kg'), 'tone' => filled($before['fat_mass']) && filled($current['fat_mass']) && (float) $current['fat_mass'] <= (float) $before['fat_mass'] ? 'good' : 'neutral'],
        ['label' => 'Peso corporal', 'before' => $formatValue($before['weight'], ' kg'), 'current' => $formatValue($current['weight'], ' kg'), 'change' => $changeValue($current['weight'], $before['weight'], ' kg'), 'tone' => 'neutral'],
    ];

    $bodyZones = [
        ['name' => 'Brazo flex.', 'value' => $formatValue($current['arm'], ' cm'), 'change' => $changeValue($current['arm'], $before['arm'], '', 2), 'class' => 'zone-arm-left'],
        ['name' => 'Torax', 'value' => $formatValue($current['chest'], ' cm'), 'change' => $changeValue($current['chest'], $before['chest'], '', 2), 'class' => 'zone-chest'],
        ['name' => 'Cintura', 'value' => $formatValue($current['waist'], ' cm'), 'change' => $changeValue($current['waist'], $before['waist'], '', 2), 'class' => 'zone-waist'],
        ['name' => 'Cadera', 'value' => $formatValue($current['hip'], ' cm'), 'change' => $changeValue($current['hip'], $before['hip'], '', 2), 'class' => 'zone-hip'],
        ['name' => 'Muslo', 'value' => $formatValue($current['thigh'], ' cm'), 'change' => $changeValue($current['thigh'], $before['thigh'], '', 2), 'class' => 'zone-leg-left'],
        ['name' => 'Pantorrilla', 'value' => $formatValue($current['calf'], ' cm'), 'change' => $changeValue($current['calf'], $before['calf'], '', 2), 'class' => 'zone-calf-right'],
    ];

    $measurementValue = fn (string $zoneName) => (float) str_replace(',', '.', collect($bodyZones)->firstWhere('name', $zoneName)['value'] ?? 0);
    $visualSize = fn (float $value, float $minValue, float $maxValue, int $minPixels, int $maxPixels) => round(
        $minPixels + ((max($minValue, min($value, $maxValue)) - $minValue) / ($maxValue - $minValue)) * ($maxPixels - $minPixels)
    );

    $bodyShape = [
        'chest' => $visualSize($measurementValue('Torax'), 78, 125, 92, 146),
        'waist' => $visualSize($measurementValue('Cintura'), 58, 115, 62, 126),
        'hips' => $visualSize($measurementValue('Cadera'), 78, 130, 94, 152),
        'arm' => $visualSize($measurementValue('Brazo flex.'), 24, 46, 24, 44),
        'leg' => $visualSize($measurementValue('Muslo'), 42, 75, 34, 58),
        'calf' => $visualSize($measurementValue('Pantorrilla'), 28, 50, 26, 44),
    ];
    $bodyShape['armOffset'] = round(165 - ($bodyShape['chest'] / 2) - $bodyShape['arm'] - 5);
    $miniShape = fn (array $source, bool $isCurrent = false) => [
        'chest' => $visualSize((float) ($source['chest'] ?: 95), 78, 125, $isCurrent ? 76 : 82, $isCurrent ? 106 : 116),
        'waist' => $visualSize((float) ($source['waist'] ?: 78), 58, 115, $isCurrent ? 54 : 60, $isCurrent ? 102 : 110),
        'hip' => $visualSize((float) ($source['hip'] ?: 96), 78, 130, $isCurrent ? 74 : 82, $isCurrent ? 112 : 120),
        'arm' => $visualSize((float) ($source['arm'] ?: 30), 24, 46, $isCurrent ? 18 : 20, $isCurrent ? 32 : 36),
        'leg' => $visualSize((float) ($source['thigh'] ?: 52), 42, 75, $isCurrent ? 24 : 26, $isCurrent ? 42 : 48),
        'calf' => $visualSize((float) ($source['calf'] ?: 34), 28, 50, $isCurrent ? 20 : 22, $isCurrent ? 36 : 40),
    ];
    $previousMiniShape = $miniShape($before, false);
    $currentMiniShape = $miniShape($current, true);
    $morphClass = function (array $source): string {
        $bodyFat = filled($source['body_fat'] ?? null) ? (float) $source['body_fat'] : null;
        $waist = filled($source['waist'] ?? null) ? (float) $source['waist'] : null;
        $leanMass = filled($source['lean_mass'] ?? null) ? (float) $source['lean_mass'] : null;

        if (($bodyFat !== null && $bodyFat >= 28) || ($waist !== null && $waist >= 95)) {
            return 'morph-full';
        }

        if (($bodyFat !== null && $bodyFat <= 16) || ($leanMass !== null && $leanMass >= 58)) {
            return 'morph-athletic';
        }

        if (($bodyFat !== null && $bodyFat <= 20) || ($waist !== null && $waist <= 72)) {
            return 'morph-slim';
        }

        return 'morph-balanced';
    };
    $genderClass = ($user->gender ?? '') === 'Femenino' ? 'gender-female' : 'gender-male';
    $previousMorphClass = $morphClass($before);
    $currentMorphClass = $morphClass($current);
    $avatarPosition = function (string $genderClass, string $morphClass): string {
        $columns = [
            'morph-full' => 0,
            'morph-slim' => 33.333,
            'morph-balanced' => 66.666,
            'morph-athletic' => 100,
        ];

        return 'background-position: '.($columns[$morphClass] ?? 66.666).'% '.($genderClass === 'gender-female' ? 100 : 0).'%;';
    };
    $visualClass = match ($bodyVisualType ?? 'scan') {
        'avatar' => 'visual-avatar',
        'realistic' => 'visual-realistic',
        'silhouette' => 'visual-silhouette',
        'athletic' => 'visual-athletic',
        default => 'visual-scan',
    };

    $history = $measurements
        ->sortBy('measured_at')
        ->take(-4)
        ->values()
        ->map(fn ($measurement) => [
            'month' => $measurement->measured_at->translatedFormat('M'),
            'fat' => filled($measurement->body_fat) ? max(8, min(100, (float) $measurement->body_fat * 3)) : 12,
            'muscle' => filled($measurement->lean_mass) ? max(8, min(100, (float) $measurement->lean_mass * 1.2)) : 12,
            'weight' => $measurement->weight ? $measurement->weight.' kg' : '-',
            'waist' => $measurement->waist ? $measurement->waist.' cm' : '-',
        ])
        ->all();

    if (empty($history)) {
        $history = [[
            'month' => 'Base',
            'fat' => filled($current['body_fat']) ? max(8, min(100, (float) $current['body_fat'] * 3)) : 12,
            'muscle' => filled($current['lean_mass']) ? max(8, min(100, (float) $current['lean_mass'] * 1.2)) : 12,
            'weight' => $formatValue($current['weight'], ' kg'),
            'waist' => $formatValue($current['waist'], ' cm'),
        ]];
    }

    $monthlyChanges = [
        ['label' => 'Grasa corporal', 'start' => $formatValue($before['body_fat'], '%'), 'current' => $formatValue($current['body_fat'], '%'), 'total' => $changeValue($current['body_fat'], $before['body_fat'], '%'), 'result' => 'Seguimiento'],
        ['label' => 'Masa magra', 'start' => $formatValue($before['lean_mass'], ' kg'), 'current' => $formatValue($current['lean_mass'], ' kg'), 'total' => $changeValue($current['lean_mass'], $before['lean_mass'], ' kg'), 'result' => 'Seguimiento'],
        ['label' => 'Cintura', 'start' => $formatValue($before['waist'], ' cm'), 'current' => $formatValue($current['waist'], ' cm'), 'total' => $changeValue($current['waist'], $before['waist'], ' cm'), 'result' => 'Seguimiento'],
        ['label' => 'Peso', 'start' => $formatValue($before['weight'], ' kg'), 'current' => $formatValue($current['weight'], ' kg'), 'total' => $changeValue($current['weight'], $before['weight'], ' kg'), 'result' => 'Seguimiento'],
    ];

    $compareZones = [
        ['name' => 'Brazo flex.', 'previous' => $formatValue($before['arm'], ' cm'), 'current' => $formatValue($current['arm'], ' cm'), 'change' => $changeValue($current['arm'], $before['arm'])],
        ['name' => 'Torax', 'previous' => $formatValue($before['chest'], ' cm'), 'current' => $formatValue($current['chest'], ' cm'), 'change' => $changeValue($current['chest'], $before['chest'])],
        ['name' => 'Cintura', 'previous' => $formatValue($before['waist'], ' cm'), 'current' => $formatValue($current['waist'], ' cm'), 'change' => $changeValue($current['waist'], $before['waist'])],
        ['name' => 'Cadera', 'previous' => $formatValue($before['hip'], ' cm'), 'current' => $formatValue($current['hip'], ' cm'), 'change' => $changeValue($current['hip'], $before['hip'])],
        ['name' => 'Muslo', 'previous' => $formatValue($before['thigh'], ' cm'), 'current' => $formatValue($current['thigh'], ' cm'), 'change' => $changeValue($current['thigh'], $before['thigh'])],
        ['name' => 'Pantorrilla', 'previous' => $formatValue($before['calf'], ' cm'), 'current' => $formatValue($current['calf'], ' cm'), 'change' => $changeValue($current['calf'], $before['calf'])],
    ];
@endphp

<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.progreso') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">{{ $latestDate ? $latestDate->format('d/m/Y') : 'Sin medicion' }}</span>
    </div>

    <div class="body-report-hero mb-4">
        <div class="page-kicker text-white">
            <i class="bi bi-stars"></i> Resultados del mes
        </div>
        <h1 class="fit-title text-white mb-2">Tu entrenamiento si se nota</h1>
        <p class="text-white-50 mb-0">
            {{ $latestMeasurement ? 'Estos son tus datos mas recientes capturados por tu coach.' : 'Aun no tienes una medicion completa registrada. Esta vista se actualizara cuando tu coach capture tus datos.' }}
        </p>
    </div>

    <div class="body-report-score mb-4">
        <div>
            <div class="body-score-label">Lectura del coach</div>
            <div class="body-score-title">{{ $previousMeasurement ? 'Comparativo disponible' : 'Medicion base' }}</div>
            <div class="fit-subtitle">{{ $previousMeasurement ? 'Comparado contra tu medicion anterior.' : 'Primer punto de partida para tu progreso.' }}</div>
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
            <div class="human-map" aria-label="Mapa corporal visual" style="--body-chest-width: {{ $bodyShape['chest'] }}px; --body-waist-width: {{ $bodyShape['waist'] }}px; --body-hip-width: {{ $bodyShape['hips'] }}px; --body-arm-width: {{ $bodyShape['arm'] }}px; --body-leg-width: {{ $bodyShape['leg'] }}px; --body-calf-width: {{ $bodyShape['calf'] }}px; --body-arm-offset: {{ $bodyShape['armOffset'] }}px;">
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
        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Comparar mediciones</h2>
            <span class="mini-note">Actual vs mes elegido</span>
        </div>

        <div class="compare-month-tabs mb-3">
            <button class="compare-month-tab">Ene</button>
            <button class="compare-month-tab active">Feb</button>
            <button class="compare-month-tab">Mar</button>
        </div>

        <div class="body-compare-stage mb-3">
            <div class="compare-body-card previous">
                <div class="compare-body-head">
                    <span>Febrero</span>
                    <strong>Medicion anterior</strong>
                </div>
                @if(($bodyVisualType ?? 'avatar') === 'avatar')
                    <div class="body-avatar-figure" style="{{ $avatarPosition($genderClass, $previousMorphClass) }}">
                        <div class="mini-measure hip"></div>
                        <div class="mini-measure waist"></div>
                        <div class="mini-measure chest"></div>
                    </div>
                @else
                    <div class="mini-human {{ $visualClass }} {{ $genderClass }} {{ $previousMorphClass }} is-wide" style="--mini-chest-width: {{ $previousMiniShape['chest'] }}px; --mini-waist-width: {{ $previousMiniShape['waist'] }}px; --mini-hip-width: {{ $previousMiniShape['hip'] }}px; --mini-arm-width: {{ $previousMiniShape['arm'] }}px; --mini-leg-width: {{ $previousMiniShape['leg'] }}px; --mini-calf-width: {{ $previousMiniShape['calf'] }}px;">
                        <div class="mini-human-head"></div>
                        <div class="mini-human-neck"></div>
                        <div class="mini-human-body"></div>
                        <div class="mini-human-chest"></div>
                        <div class="mini-human-waist"></div>
                        <div class="mini-human-hips"></div>
                        <div class="mini-human-arm left"></div>
                        <div class="mini-human-arm right"></div>
                        <div class="mini-human-leg left"></div>
                        <div class="mini-human-leg right"></div>
                        <div class="mini-human-calf left"></div>
                        <div class="mini-human-calf right"></div>
                        <div class="mini-measure hip"></div>
                        <div class="mini-measure waist"></div>
                        <div class="mini-measure chest"></div>
                    </div>
                @endif
                <div class="compare-body-foot">
                    <span>Grasa {{ $formatValue($before['body_fat'], '%') }}</span>
                    <span>Cintura {{ $formatValue($before['waist'], ' cm') }}</span>
                </div>
            </div>

            <div class="compare-body-card current">
                <div class="compare-body-head">
                    <span>Abril</span>
                    <strong>Medicion actual</strong>
                </div>
                @if(($bodyVisualType ?? 'avatar') === 'avatar')
                    <div class="body-avatar-figure" style="{{ $avatarPosition($genderClass, $currentMorphClass) }}">
                        <div class="mini-measure hip"></div>
                        <div class="mini-measure waist"></div>
                        <div class="mini-measure chest"></div>
                    </div>
                @else
                    <div class="mini-human {{ $visualClass }} {{ $genderClass }} {{ $currentMorphClass }} is-current is-lean" style="--mini-chest-width: {{ $currentMiniShape['chest'] }}px; --mini-waist-width: {{ $currentMiniShape['waist'] }}px; --mini-hip-width: {{ $currentMiniShape['hip'] }}px; --mini-arm-width: {{ $currentMiniShape['arm'] }}px; --mini-leg-width: {{ $currentMiniShape['leg'] }}px; --mini-calf-width: {{ $currentMiniShape['calf'] }}px;">
                        <div class="mini-human-head"></div>
                        <div class="mini-human-neck"></div>
                        <div class="mini-human-body"></div>
                        <div class="mini-human-chest"></div>
                        <div class="mini-human-waist"></div>
                        <div class="mini-human-hips"></div>
                        <div class="mini-human-arm left"></div>
                        <div class="mini-human-arm right"></div>
                        <div class="mini-human-leg left"></div>
                        <div class="mini-human-leg right"></div>
                        <div class="mini-human-calf left"></div>
                        <div class="mini-human-calf right"></div>
                        <div class="mini-measure hip"></div>
                        <div class="mini-measure waist"></div>
                        <div class="mini-measure chest"></div>
                    </div>
                @endif
                <div class="compare-body-foot">
                    <span>Grasa {{ $formatValue($current['body_fat'], '%') }}</span>
                    <span>Cintura {{ $formatValue($current['waist'], ' cm') }}</span>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            @foreach($compareZones as $zone)
                <div class="zone-compare-row">
                    <div>
                        <div class="fw-bold">{{ $zone['name'] }}</div>
                        <div class="fit-subtitle">{{ $zone['previous'] }} -> {{ $zone['current'] }}</div>
                    </div>
                    <span class="status-pill status-ok">{{ $zone['change'] }}</span>
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
                <div class="fit-subtitle">Grasa actual: {{ $formatValue($current['body_fat'], '%') }}. Anterior: {{ $formatValue($before['body_fat'], '%') }}.</div>
            </div>
        </div>

        <div class="result-insight good mb-3">
            <i class="bi bi-arrow-up-right"></i>
            <div>
                <div class="fw-bold">Subiste masa magra</div>
                <div class="fit-subtitle">Masa magra actual: {{ $formatValue($current['lean_mass'], ' kg') }}. Cambio: {{ $changeValue($current['lean_mass'], $before['lean_mass'], ' kg') }}.</div>
            </div>
        </div>

        <div class="result-insight neutral">
            <i class="bi bi-dash-lg"></i>
            <div>
                <div class="fw-bold">El peso se mantuvo</div>
                <div class="fit-subtitle">Peso actual: {{ $formatValue($current['weight'], ' kg') }}. Cambio: {{ $changeValue($current['weight'], $before['weight'], ' kg') }}.</div>
            </div>
        </div>
    </div>

    <div class="coach-summary-card mb-4">
        <div class="fw-bold mb-2">Siguiente ajuste del coach</div>
        <p class="mb-3">
            {{ $latestMeasurement?->notes ?: 'Tu coach aun no ha dejado notas sobre esta medicion.' }}
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
