@extends('layouts.fitapp-admin')

@section('title', 'Detalle de rutina | FitCoach Admin')

@section('content')
@php
    $days = [
        [
            'name' => 'Dia 1',
            'focus' => 'Pierna y gluteo',
            'time' => '60 min',
            'exercises' => [
                ['order' => '1', 'name' => 'Hip Thrust', 'type' => 'Individual', 'dose' => '4 x 10-12', 'rest' => '90 seg', 'evidence' => true],
                ['order' => '2A', 'name' => 'Sentadilla Goblet', 'type' => 'Biserie', 'dose' => '3 x 12', 'rest' => '75 seg al final', 'evidence' => false],
                ['order' => '2B', 'name' => 'Abduccion con Banda', 'type' => 'Biserie', 'dose' => '3 x 20', 'rest' => '75 seg al final', 'evidence' => false],
                ['order' => '3', 'name' => 'Peso Muerto Rumano', 'type' => 'Individual', 'dose' => '3 x 10', 'rest' => '90 seg', 'evidence' => true],
            ],
        ],
        [
            'name' => 'Dia 2',
            'focus' => 'Espalda y biceps',
            'time' => '55 min',
            'exercises' => [
                ['order' => '1', 'name' => 'Jalon al Pecho', 'type' => 'Individual', 'dose' => '4 x 10', 'rest' => '75 seg', 'evidence' => false],
                ['order' => '2', 'name' => 'Remo con Mancuerna', 'type' => 'Individual', 'dose' => '3 x 12', 'rest' => '75 seg', 'evidence' => true],
            ],
        ],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Rutina Masa muscular - Intermedio</h1>
        <div class="admin-topbar-subtitle">Vista de estructura: dias, ejercicios, biseries, descansos, evidencias e indicaciones.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.rutinas') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="btn btn-primary-custom px-4">Editar rutina</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Resumen del plan</h2>
                <div class="admin-mini">Informacion general que vera el coach antes de asignarla</div>
            </div>

            <div class="admin-form-card-body">
                <div class="routine-summary-grid">
                    <div>
                        <span>Objetivo</span>
                        <strong>Masa muscular</strong>
                    </div>
                    <div>
                        <span>Nivel</span>
                        <strong>Intermedio</strong>
                    </div>
                    <div>
                        <span>Duracion</span>
                        <strong>4 semanas</strong>
                    </div>
                    <div>
                        <span>Lugar</span>
                        <strong>Gimnasio</strong>
                    </div>
                </div>

                <div class="routine-note mt-3">
                    Proposito: desarrollar hipertrofia con tecnica limpia, cargas progresivas y evidencia en ejercicios principales.
                </div>
            </div>
        </div>

        @foreach($days as $day)
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2 class="admin-panel-title mb-1">{{ $day['name'] }} - {{ $day['focus'] }}</h2>
                            <div class="admin-mini">Tiempo estimado: {{ $day['time'] }}</div>
                        </div>
                        <span class="admin-tag blue">{{ count($day['exercises']) }} ejercicios</span>
                    </div>
                </div>

                <div class="admin-form-card-body">
                    <div class="routine-table-wrap">
                        <table class="routine-table">
                            <thead>
                                <tr>
                                    <th>Orden</th>
                                    <th>Ejercicio</th>
                                    <th>Tipo</th>
                                    <th>Series / reps</th>
                                    <th>Descanso</th>
                                    <th>Evidencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($day['exercises'] as $exercise)
                                    <tr>
                                        <td><span class="routine-order compact">{{ $exercise['order'] }}</span></td>
                                        <td>
                                            <div class="fw-bold">{{ $exercise['name'] }}</div>
                                            <div class="admin-mini">Desde biblioteca de ejercicios</div>
                                        </td>
                                        <td>
                                            <span class="admin-tag {{ $exercise['type'] === 'Biserie' ? 'yellow' : '' }}">
                                                {{ $exercise['type'] }}
                                            </span>
                                        </td>
                                        <td>{{ $exercise['dose'] }}</td>
                                        <td>{{ $exercise['rest'] }}</td>
                                        <td>
                                            @if($exercise['evidence'])
                                                <span class="admin-tag blue">Video</span>
                                            @else
                                                <span class="admin-tag">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Control de rutina</h2>
                <div class="admin-mini">Estado y uso administrativo</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <div class="value">4</div>
                        <div class="label">Dias</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <div class="value">18</div>
                        <div class="label">Ejercicios</div>
                    </div>
                </div>

                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <div class="value">3</div>
                        <div class="label">Biseries</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <div class="value">7</div>
                        <div class="label">Evidencias</div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary-custom">Asignar a usuario</button>
                    <button class="btn btn-soft-custom">Duplicar plantilla</button>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Regla importante</div>
            <div class="admin-mini">
                Las biseries comparten descanso al final del bloque. Los ejercicios con evidencia generan pendiente en el panel de evidencias del coach.
            </div>
        </div>
    </div>
</div>
@endsection
