@extends('layouts.fitapp-admin')

@section('title', 'Mediciones | FitCoach Admin')

@section('content')
@php
    $records = [
        [
            'user' => 'Adrian',
            'date' => '15 Abr 2026',
            'appointment' => 'Valoracion inicial',
            'weight' => '65.300 kg',
            'fat' => '14.73%',
            'lean' => '55.681 kg',
            'waist' => '81.20 cm',
            'status' => 'Completa',
        ],
        [
            'user' => 'Maria Gonzalez',
            'date' => '09 Abr 2026',
            'appointment' => 'Seguimiento mensual',
            'weight' => '62.800 kg',
            'fat' => '18.20%',
            'lean' => '51.370 kg',
            'waist' => '74.60 cm',
            'status' => 'Completa',
        ],
        [
            'user' => 'Jorge Ramirez',
            'date' => '12 Abr 2026',
            'appointment' => 'Cita inicial',
            'weight' => '83.100 kg',
            'fat' => '24.10%',
            'lean' => '63.073 kg',
            'waist' => '94.30 cm',
            'status' => 'Por revisar',
        ],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Mediciones</h1>
        <div class="admin-topbar-subtitle">Cada cita genera un registro de medicion para consultar historial y progreso corporal.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="btn btn-primary-custom px-4">Nueva medicion</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Mediciones del mes</div>
        <div class="admin-stat-value">28</div>
        <div class="admin-stat-note">Valoraciones y seguimientos</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Citas con medicion</div>
        <div class="admin-stat-value">19</div>
        <div class="admin-stat-note">Registros completos</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Por capturar</div>
        <div class="admin-stat-value">6</div>
        <div class="admin-stat-note">Despues de cita</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Renovaciones</div>
        <div class="admin-stat-value">4</div>
        <div class="admin-stat-note">Usan progreso para ajustar plan</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todas</span>
    <span class="admin-filter-chip">Valoracion inicial</span>
    <span class="admin-filter-chip">Seguimiento mensual</span>
    <span class="admin-filter-chip">Por capturar</span>
    <span class="admin-filter-chip">Con meta</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar usuario o fecha...">
    </div>
</div>

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title">Historial de mediciones</h2>
                <span class="small text-muted">Demo visual</span>
            </div>

            <div class="admin-panel-body">
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Cita</th>
                                <th>Peso</th>
                                <th>Grasa</th>
                                <th>Masa magra</th>
                                <th>Cintura</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>
                                        <strong>{{ $record['user'] }}</strong>
                                        <div class="small text-muted">Expediente corporal</div>
                                    </td>
                                    <td>{{ $record['date'] }}</td>
                                    <td>{{ $record['appointment'] }}</td>
                                    <td>{{ $record['weight'] }}</td>
                                    <td>{{ $record['fat'] }}</td>
                                    <td>{{ $record['lean'] }}</td>
                                    <td>{{ $record['waist'] }}</td>
                                    <td>
                                        <span class="admin-tag {{ $record['status'] === 'Completa' ? 'blue' : 'yellow' }}">
                                            {{ $record['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Detalle del registro seleccionado</h2>
                <div class="admin-mini">Ejemplo basado en la medicion de Adrian del 15 de Abril 2026.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="routine-summary-grid mb-3">
                    <div><span>Grasa corporal</span><strong>14.73%</strong></div>
                    <div><span>Masa magra</span><strong>55.681 kg</strong></div>
                    <div><span>Masa grasa</span><strong>9.619 kg</strong></div>
                    <div><span>Peso corporal</span><strong>65.300 kg</strong></div>
                </div>

                <div class="admin-table-wrap mb-3">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Indicador</th>
                                <th>Actual</th>
                                <th>Meta</th>
                                <th>Cambio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Grasa Corporal (%)</td><td>14.73%</td><td>14.00%</td><td><span class="admin-tag blue">-0.73%</span></td></tr>
                            <tr><td>Masa Magra (kgs)</td><td>55.681</td><td>56.158</td><td><span class="admin-tag blue">0.48</span></td></tr>
                            <tr><td>Masa Grasa (kgs)</td><td>9.619</td><td>9.142</td><td><span class="admin-tag blue">-0.48</span></td></tr>
                            <tr><td>Peso Corporal (kgs)</td><td>65.300</td><td>65.300</td><td><span class="admin-tag">0.000</span></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="admin-card-actions">
                    <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar registro</a>
                    <a href="{{ route('fitapp.admin.usuarios.detalle') }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Ver usuario</a>
                    <a href="{{ route('fitapp.admin.mediciones.reporte') }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver reporte visual</a>
                    <a href="{{ route('fitapp.progreso-corporal') }}" class="admin-btn-soft"><i class="bi bi-phone"></i> Mostrar al usuario</a>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Progreso visual</h2>
                <div class="admin-mini">Comparativo entre mediciones.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Grasa corporal</div>
                                <div class="small text-muted">15.46% anterior -> 14.73% actual</div>
                            </div>
                            <span class="admin-tag blue">Mejora</span>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Masa magra</div>
                                <div class="small text-muted">55.20 kg anterior -> 55.681 kg actual</div>
                            </div>
                            <span class="admin-tag blue">+0.48</span>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Cintura</div>
                                <div class="small text-muted">83.00 cm anterior -> 81.20 cm actual</div>
                            </div>
                            <span class="admin-tag blue">-1.80 cm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Como debe funcionar despues</div>
            <div class="admin-mini">
                Cada registro se guardara con usuario, fecha de cita, composicion corporal, calculos caloricos, pliegues, perimetros y notas. Asi el coach puede comparar progreso antes de renovar el plan mensual.
            </div>
        </div>
    </div>
</div>
@endsection
