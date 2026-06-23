@extends('layouts.fitapp')

@section('title', 'Detalle de rutina | FitApp')

@section('content')
@php
    $exercises = $day?->exercises ?? collect();
    $evidenceCount = $exercises->where('requires_evidence', true)->count();
@endphp

<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.rutina') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Detalle del dia</span>
    </div>

    @if($activePlan && $day)
        <div class="day-focus-card mb-4">
            <div class="page-kicker text-white mb-1">
                <i class="bi bi-calendar-day"></i> {{ $day->day_name }}
            </div>
            <h1 class="fit-title text-white mb-2">{{ $day->focus ?: $activePlan->name }}</h1>
            <p class="text-white-50 mb-0">
                {{ $activePlan->goal ?: 'Sigue las indicaciones del coach y registra evidencias donde se soliciten.' }}
            </p>

            <div class="day-focus-grid">
                <div class="day-focus-stat">
                    <div class="value">{{ $exercises->count() }}</div>
                    <div class="label">Ejercicios</div>
                </div>
                <div class="day-focus-stat">
                    <div class="value">{{ $evidenceCount }}</div>
                    <div class="label">Evidencias</div>
                </div>
                <div class="day-focus-stat">
                    <div class="value">{{ $day->estimated_time ?: '-' }}</div>
                    <div class="label">Duracion</div>
                </div>
            </div>
        </div>

        <div class="coach-note-box mb-4">
            <div class="fw-bold mb-2">Indicaciones generales del coach</div>
            @if($activePlan->notes)
                <div class="fit-subtitle mb-0">{{ $activePlan->notes }}</div>
            @else
                <ul class="exercise-info-list mb-0">
                    <li>Calienta antes de empezar.</li>
                    <li>Cuida la tecnica y respeta los descansos indicados.</li>
                    <li>En los ejercicios marcados, sube video individual para revision.</li>
                </ul>
            @endif
        </div>

        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Ejercicios del dia</h2>
            <span class="mini-note">Toca para ver detalle</span>
        </div>

        <div class="d-grid gap-3">
            @forelse($exercises as $exercise)
                @php
                    $modalId = 'exerciseModal'.$exercise->id;
                    $catalogExercise = $exercise->exercise;
                    $exerciseLine = collect([
                        $exercise->sets ? $exercise->sets.' series' : null,
                        $exercise->reps ? $exercise->reps.' reps' : null,
                        $exercise->rest ? 'descanso '.$exercise->rest : null,
                    ])->filter()->join(' x ');
                @endphp

                <button type="button" class="exercise-card-btn" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                    <div class="exercise-card">
                        <div class="exercise-card-head">
                            <div class="d-flex gap-3 flex-grow-1">
                                <div class="exercise-thumb">
                                    <i class="bi bi-play-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="exercise-title">{{ $exercise->name }}</div>
                                    <div class="exercise-sub">{{ $exerciseLine ?: 'Indicaciones del coach' }}</div>

                                    <div class="exercise-tags">
                                        @if($exercise->block_type)
                                            <span class="exercise-tag is-coach">
                                                <i class="bi bi-ui-checks-grid"></i> {{ $exercise->block_type }}{{ $exercise->block_group ? ' '.$exercise->block_group : '' }}
                                            </span>
                                        @endif
                                        @if($exercise->requires_evidence)
                                            <span class="exercise-tag is-required">
                                                <i class="bi bi-upload"></i> Evidencia requerida
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <i class="bi bi-chevron-right text-muted"></i>
                        </div>

                        @if($exercise->notes || $exercise->tempo || $catalogExercise?->purpose)
                            <div class="exercise-purpose">
                                <div class="exercise-purpose-title">Indicacion</div>
                                <div class="exercise-purpose-text">
                                    {{ $exercise->notes ?: ($catalogExercise?->purpose ? strip_tags($catalogExercise->purpose) : 'Tempo: '.$exercise->tempo) }}
                                </div>
                            </div>
                        @endif
                    </div>
                </button>
            @empty
                <div class="coach-note-box">
                    <div class="fw-bold mb-2">Sin ejercicios capturados</div>
                    <div class="fit-subtitle mb-0">Tu coach todavia no agrego ejercicios para este dia.</div>
                </div>
            @endforelse
        </div>
    @else
        <div class="coach-note-box">
            <div class="fw-bold mb-2">Aun no tienes rutina activa</div>
            <div class="fit-subtitle mb-0">
                Cuando tu coach te asigne una rutina, aqui apareceran los ejercicios del dia.
            </div>
        </div>
    @endif
</div>

@if($activePlan && $day)
    @foreach($exercises as $exercise)
        @php
            $modalId = 'exerciseModal'.$exercise->id;
            $catalogExercise = $exercise->exercise;
        @endphp

        <div class="modal fade modal-fitapp" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title fw-bold mb-1">{{ $exercise->name }}</h5>
                            <div class="small text-muted">
                                {{ collect([$exercise->sets ? $exercise->sets.' series' : null, $exercise->reps ? $exercise->reps.' reps' : null, $exercise->rest ? 'descanso '.$exercise->rest : null])->filter()->join(' x ') ?: $day->day_name }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="exercise-demo-box mb-3">
                            @include('fitapp.partials.exercise-demo', [
                                'exercise' => $catalogExercise,
                                'emptyTitle' => 'Demo del ejercicio',
                                'emptyText' => 'Aqui podra ir el video, GIF o imagen que el coach agregue al catalogo de ejercicios.',
                            ])
                        </div>

                        <div class="surface-card p-3 mb-3">
                            <div class="fw-bold mb-2">Indicaciones</div>
                            <ul class="exercise-info-list mb-0">
                                @if($exercise->block_type)
                                    <li>Bloque: {{ $exercise->block_type }}</li>
                                @endif
                                @if($exercise->tempo)
                                    <li>Tempo: {{ $exercise->tempo }}</li>
                                @endif
                                @if($exercise->notes)
                                    <li>{{ $exercise->notes }}</li>
                                @endif
                                @if(! $exercise->block_type && ! $exercise->tempo && ! $exercise->notes && ! $catalogExercise?->coach_notes)
                                    <li>Sigue el rango, descanso y tecnica indicados por tu coach.</li>
                                @endif
                            </ul>
                        </div>

                        @if($catalogExercise?->purpose || $catalogExercise?->coach_notes || $catalogExercise?->common_mistakes)
                            <div class="surface-card p-3 mb-3 exercise-rich-content">
                                @if($catalogExercise?->purpose)
                                    <div class="fw-bold mb-2">Para que sirve</div>
                                    {!! $catalogExercise->purpose !!}
                                @endif
                                @if($catalogExercise?->coach_notes)
                                    <div class="fw-bold mt-3 mb-2">Indicaciones del coach</div>
                                    {!! $catalogExercise->coach_notes !!}
                                @endif
                                @if($catalogExercise?->common_mistakes)
                                    <div class="fw-bold mt-3 mb-2">Errores comunes</div>
                                    {!! $catalogExercise->common_mistakes !!}
                                @endif
                            </div>
                        @endif

                        @if($exercise->requires_evidence)
                            <div class="exercise-evidence-box">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                    <div>
                                        <div class="fw-bold">Evidencia requerida</div>
                                        <div class="small text-muted">Sube un video corto de una serie completa.</div>
                                    </div>
                                    <span class="status-pill status-warn">Pendiente</span>
                                </div>

                                <button class="btn btn-primary-custom w-100">
                                    Subir video de este ejercicio
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
