@extends('layouts.fitapp-admin')

@section('title', 'Reporte visual corporal | FitCoach Admin')

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

    $compareZones = [
        ['name' => 'Brazo flex.', 'previous' => '33.10 cm', 'current' => '33.80 cm', 'change' => '+0.70'],
        ['name' => 'Torax', 'previous' => '95.80 cm', 'current' => '97.00 cm', 'change' => '+1.20'],
        ['name' => 'Cintura', 'previous' => '83.00 cm', 'current' => '81.20 cm', 'change' => '-1.80'],
        ['name' => 'Cadera', 'previous' => '91.70 cm', 'current' => '92.50 cm', 'change' => '+0.80'],
        ['name' => 'Muslo', 'previous' => '55.50 cm', 'current' => '56.10 cm', 'change' => '+0.60'],
        ['name' => 'Pantorrilla', 'previous' => '35.90 cm', 'current' => '36.20 cm', 'change' => '+0.30'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Reporte visual corporal</h1>
        <div class="admin-topbar-subtitle">Vista para que el entrenador explique resultados de la medicion y compare avances del mes.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.mediciones') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.progreso') }}" class="btn btn-primary-custom px-4">Vista usuario</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="body-report-hero">
            <div class="page-kicker text-white">
                <i class="bi bi-stars"></i> Adrian - 15 Abril 2026
            </div>
            <h1 class="fit-title text-white mb-2">Tu entrenamiento si se nota</h1>
            <p class="text-white-50 mb-0">
                Bajaste grasa, mantuviste peso y subiste masa magra. El cuerpo esta cambiando aunque la bascula no se mueva.
            </p>
        </div>

        <div class="body-report-score">
            <div>
                <div class="body-score-label">Lectura del coach</div>
                <div class="body-score-title">Progreso positivo</div>
                <div class="fit-subtitle">Comparado contra la medicion anterior.</div>
            </div>
            <div class="body-score-ring">
                <span>86</span>
                <small>/100</small>
            </div>
        </div>

        <div class="row g-3">
            @foreach($metrics as $metric)
                <div class="col-md-3 col-sm-6">
                    <div class="body-metric-card {{ $metric['tone'] === 'good' ? 'is-good' : '' }}">
                        <div class="body-metric-label">{{ $metric['label'] }}</div>
                        <div class="body-metric-value">{{ $metric['current'] }}</div>
                        <div class="body-metric-compare">
                            <span>Antes: {{ $metric['before'] }}</span>
                            <strong>{{ $metric['change'] }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Mapa corporal para explicar avances</h2>
                <div class="admin-mini">El coach puede usar este bloque durante la cita para mostrar que zonas cambiaron.</div>
            </div>

            <div class="admin-form-card-body">
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
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Comparativo mensual</h2>
                <div class="admin-mini">Grasa contra masa magra en los ultimos registros y diferencia acumulada.</div>
            </div>

            <div class="admin-form-card-body">
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

                <div class="body-month-track mt-4 mb-3">
                    @foreach($history as $point)
                        <div class="body-month-step {{ $loop->last ? 'active' : '' }}">
                            <span>{{ $point['month'] }}</span>
                            <strong>{{ $point['weight'] }}</strong>
                            <em>{{ $point['waist'] }}</em>
                        </div>
                    @endforeach
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Indicador</th>
                                <th>Inicio</th>
                                <th>Actual</th>
                                <th>Diferencia</th>
                                <th>Lectura</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyChanges as $change)
                                <tr>
                                    <td><strong>{{ $change['label'] }}</strong></td>
                                    <td>{{ $change['start'] }}</td>
                                    <td>{{ $change['current'] }}</td>
                                    <td><span class="admin-tag blue">{{ $change['total'] }}</span></td>
                                    <td>{{ $change['result'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Comparar medicion actual contra otro mes</h2>
                <div class="admin-mini">El coach elige un mes y muestra dos cuerpos para explicar diferencias por zona.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="compare-month-tabs mb-3">
                    <button class="compare-month-tab">Enero</button>
                    <button class="compare-month-tab active">Febrero</button>
                    <button class="compare-month-tab">Marzo</button>
                </div>

                <div class="body-compare-stage mb-3">
                    <div class="compare-body-card previous">
                        <div class="compare-body-head">
                            <span>Febrero</span>
                            <strong>Medicion anterior</strong>
                        </div>
                        <div class="mini-human">
                            <div class="mini-human-head"></div>
                            <div class="mini-human-body"></div>
                            <div class="mini-human-arm left"></div>
                            <div class="mini-human-arm right"></div>
                            <div class="mini-human-leg left"></div>
                            <div class="mini-human-leg right"></div>
                            <div class="mini-measure waist"></div>
                            <div class="mini-measure chest"></div>
                        </div>
                        <div class="compare-body-foot">
                            <span>Grasa 15.46%</span>
                            <span>Cintura 83.00 cm</span>
                        </div>
                    </div>

                    <div class="compare-body-card current">
                        <div class="compare-body-head">
                            <span>Abril</span>
                            <strong>Medicion actual</strong>
                        </div>
                        <div class="mini-human is-current">
                            <div class="mini-human-head"></div>
                            <div class="mini-human-body"></div>
                            <div class="mini-human-arm left"></div>
                            <div class="mini-human-arm right"></div>
                            <div class="mini-human-leg left"></div>
                            <div class="mini-human-leg right"></div>
                            <div class="mini-measure waist"></div>
                            <div class="mini-measure chest"></div>
                        </div>
                        <div class="compare-body-foot">
                            <span>Grasa 14.73%</span>
                            <span>Cintura 81.20 cm</span>
                        </div>
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Zona</th>
                                <th>Mes elegido</th>
                                <th>Actual</th>
                                <th>Diferencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compareZones as $zone)
                                <tr>
                                    <td><strong>{{ $zone['name'] }}</strong></td>
                                    <td>{{ $zone['previous'] }}</td>
                                    <td>{{ $zone['current'] }}</td>
                                    <td><span class="admin-tag blue">{{ $zone['change'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Guion para el coach</h2>
                <div class="admin-mini">Puntos claros para explicar al usuario.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="result-insight good mb-3">
                    <i class="bi bi-arrow-down-right"></i>
                    <div>
                        <div class="fw-bold">Bajo grasa corporal</div>
                        <div class="fit-subtitle">Paso de 15.46% a 14.73%. Hay mejora real.</div>
                    </div>
                </div>

                <div class="result-insight good mb-3">
                    <i class="bi bi-arrow-up-right"></i>
                    <div>
                        <div class="fw-bold">Subio masa magra</div>
                        <div class="fit-subtitle">Gano 0.48 kg de masa magra.</div>
                    </div>
                </div>

                <div class="result-insight neutral">
                    <i class="bi bi-dash-lg"></i>
                    <div>
                        <div class="fw-bold">El peso se mantuvo</div>
                        <div class="fit-subtitle">La bascula no cambio, pero la composicion si.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Siguiente ajuste</h2>
                <div class="admin-mini">Acciones para el nuevo mes.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="fw-bold">Mantener calorias</div>
                        <div class="small text-muted">Cerca de 2168 kcal mientras siga progresando.</div>
                    </div>
                    <div class="admin-list-item">
                        <div class="fw-bold">Subir intensidad de pierna</div>
                        <div class="small text-muted">Ajustar cargas en ejercicios base.</div>
                    </div>
                    <div class="admin-list-item">
                        <div class="fw-bold">Nueva medicion</div>
                        <div class="small text-muted">Agendar en 4 semanas para comparar.</div>
                    </div>
                </div>

                <div class="admin-card-actions">
                    <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar datos</a>
                    <a href="{{ route('fitapp.progreso') }}" class="admin-btn-soft"><i class="bi bi-phone"></i> Abrir usuario</a>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Uso ideal</div>
            <div class="admin-mini">
                Esta vista es para el entrenador: revisa, explica y decide ajustes. La vista usuario muestra la misma historia, mas limpia para presentarla en consulta.
            </div>
        </div>
    </div>
</div>
@endsection
