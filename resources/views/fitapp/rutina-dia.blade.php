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
            @forelse($blocks as $block)
                <section class="workout-exercise-block tone-{{ $block['tone'] }} {{ $block['type'] !== 'Individual' ? 'is-grouped' : '' }} {{ $block['is_completed'] ? 'is-completed' : '' }}">
                    @if($block['type'] !== 'Individual')
                        <div class="workout-block-head">
                            <div>
                                <span class="workout-block-kicker">{{ $block['type'] }} {{ $block['group'] }}</span>
                                <div class="fw-bold">Realiza los ejercicios juntos antes de descansar</div>
                            </div>
                            <span class="workout-block-count">{{ $block['exercises']->count() }} ejercicios</span>
                        </div>
                    @endif

                    <div class="workout-block-exercises">
                        @foreach($block['exercises'] as $exercise)
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
                                            <div class="exercise-thumb"><i class="bi bi-play-circle"></i></div>
                                            <div class="flex-grow-1">
                                                <div class="exercise-title">{{ $exercise->name }}</div>
                                                <div class="exercise-sub">{{ $exerciseLine ?: 'Indicaciones del coach' }}</div>
                                                <div class="exercise-tags">
                                                    <span class="exercise-tag is-coach"><i class="bi bi-ui-checks-grid"></i> {{ $exercise->block_type }}{{ $exercise->block_group ? ' '.$exercise->block_group : '' }}</span>
                                                    @if($exercise->requires_evidence)
                                                        <span class="exercise-tag is-required"><i class="bi bi-upload"></i> Evidencia requerida</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>
                                    @if($exercise->notes || $exercise->tempo || $catalogExercise?->purpose)
                                        <div class="exercise-purpose">
                                            <div class="exercise-purpose-title">Indicacion</div>
                                            <div class="exercise-purpose-text">{{ $exercise->notes ?: ($catalogExercise?->purpose ? strip_tags($catalogExercise->purpose) : 'Tempo: '.$exercise->tempo) }}</div>
                                        </div>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>

                    @if($block['total_sets'] > 0)
                        <div class="set-progress-panel"
                             data-progress-url="{{ route('fitapp.rutina-dia.progreso', $day) }}"
                             data-progress-key="{{ $block['key'] }}"
                             data-total-sets="{{ $block['total_sets'] }}"
                             data-completed-sets="{{ $block['completed_sets'] }}"
                             data-rest-seconds="{{ $block['rest_seconds'] }}"
                             data-remaining-seconds="{{ $block['remaining_seconds'] }}">
                            <div class="set-progress-head">
                                <div>
                                    <div class="fw-bold">Progreso de series</div>
                                    <div class="mini-note set-progress-copy">{{ $block['completed_sets'] }} de {{ $block['total_sets'] }} completadas</div>
                                </div>
                                <span class="status-pill set-progress-status {{ $block['is_completed'] ? 'status-ok' : 'status-warn' }}">{{ $block['is_completed'] ? 'Completado' : 'En progreso' }}</span>
                            </div>

                            <div class="set-dots" aria-label="Series completadas">
                                @for($set = 1; $set <= $block['total_sets']; $set++)
                                    <span class="set-dot {{ $set <= $block['completed_sets'] ? 'is-done' : '' }}"><i class="bi {{ $set <= $block['completed_sets'] ? 'bi-check-lg' : 'bi-circle' }}"></i><small>{{ $set }}</small></span>
                                @endfor
                            </div>

                            <div class="rest-countdown {{ $block['remaining_seconds'] > 0 ? 'is-active' : '' }}">
                                <div class="rest-timer-ring" style="--timer-progress:0deg"><strong class="rest-timer-value">00:00</strong></div>
                                <div><div class="fw-bold">Tiempo de descanso</div><div class="mini-note">La siguiente serie inicia cuando llegue a cero.</div></div>
                            </div>

                            <div class="set-progress-actions">
                                <button type="button" class="btn btn-primary-custom mark-set-btn" {{ $block['is_completed'] ? 'disabled' : '' }}>
                                    <i class="bi bi-check2-circle me-1"></i>
                                    <span>{{ $block['is_completed'] ? 'Bloque completado' : 'Marcar serie '.($block['completed_sets'] + 1) }}</span>
                                </button>
                                <button type="button" class="btn btn-soft-custom undo-set-btn" {{ $block['completed_sets'] <= 0 ? 'disabled' : '' }} title="Deshacer ultima serie">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </section>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = @json(csrf_token());
    const progressDate = @json(now('America/Mexico_City')->toDateString());
    const timers = new WeakMap();

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainder = seconds % 60;
        return String(minutes).padStart(2, '0') + ':' + String(remainder).padStart(2, '0');
    }

    function stopTimer(panel) {
        if (timers.has(panel)) {
            clearInterval(timers.get(panel));
            timers.delete(panel);
        }
    }

    function startTimer(panel, seconds) {
        stopTimer(panel);
        const countdown = panel.querySelector('.rest-countdown');
        const value = panel.querySelector('.rest-timer-value');
        const ring = panel.querySelector('.rest-timer-ring');
        const total = Math.max(1, Number(panel.dataset.restSeconds || seconds));
        let remaining = Math.max(0, Number(seconds));

        if (remaining <= 0) {
            countdown.classList.remove('is-active');
            value.textContent = '00:00';
            ring.style.setProperty('--timer-progress', '360deg');
            return;
        }

        countdown.classList.add('is-active');
        const tick = function () {
            value.textContent = formatTime(remaining);
            ring.style.setProperty('--timer-progress', ((1 - remaining / total) * 360) + 'deg');
            if (remaining <= 0) {
                stopTimer(panel);
                countdown.classList.remove('is-active');
                return;
            }
            remaining--;
        };
        tick();
        timers.set(panel, setInterval(tick, 1000));
    }

    function renderProgress(panel, completedSets, totalSets, isCompleted) {
        panel.dataset.completedSets = completedSets;
        panel.querySelector('.set-progress-copy').textContent = completedSets + ' de ' + totalSets + ' completadas';
        const status = panel.querySelector('.set-progress-status');
        status.textContent = isCompleted ? 'Completado' : 'En progreso';
        status.classList.toggle('status-ok', isCompleted);
        status.classList.toggle('status-warn', !isCompleted);
        panel.closest('.workout-exercise-block').classList.toggle('is-completed', isCompleted);

        panel.querySelectorAll('.set-dot').forEach((dot, index) => {
            const done = index < completedSets;
            dot.classList.toggle('is-done', done);
            dot.querySelector('i').className = 'bi ' + (done ? 'bi-check-lg' : 'bi-circle');
        });

        const markButton = panel.querySelector('.mark-set-btn');
        const undoButton = panel.querySelector('.undo-set-btn');
        markButton.disabled = isCompleted;
        undoButton.disabled = completedSets <= 0;
        markButton.querySelector('span').textContent = isCompleted ? 'Bloque completado' : 'Marcar serie ' + (completedSets + 1);
    }

    async function saveProgress(panel, completedSets) {
        const previousSets = Number(panel.dataset.completedSets);
        const totalSets = Number(panel.dataset.totalSets);
        const isCompleted = completedSets >= totalSets;
        const actionTime = new Date().toISOString();
        const payload = {
            progress_key: panel.dataset.progressKey,
            completed_sets: completedSets,
            progress_date: progressDate,
            rest_started_at: completedSets > previousSets && !isCompleted ? actionTime : null,
            performed_at: actionTime
        };
        const buttons = panel.querySelectorAll('button');
        buttons.forEach(button => button.disabled = true);

        renderProgress(panel, completedSets, totalSets, isCompleted);
        startTimer(panel, completedSets > previousSets && !isCompleted ? Number(panel.dataset.restSeconds) : 0);

        if (!navigator.onLine) {
            window.FitappOffline?.queueWorkout({
                url: panel.dataset.progressUrl,
                progress_key: panel.dataset.progressKey,
                payload: payload
            });
            return;
        }

        try {
            const response = await fetch(panel.dataset.progressUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            });

            if (!response.ok) throw new Error('No se pudo guardar el progreso.');
            const data = await response.json();
            renderProgress(panel, data.completed_sets, data.total_sets, data.is_completed);
            startTimer(panel, data.rest_seconds);
        } catch (error) {
            window.FitappOffline?.queueWorkout({
                url: panel.dataset.progressUrl,
                progress_key: panel.dataset.progressKey,
                payload: payload
            });
        }
    }

    document.querySelectorAll('.set-progress-panel').forEach(panel => {
        const completed = Number(panel.dataset.completedSets || 0);
        const total = Number(panel.dataset.totalSets || 0);
        renderProgress(panel, completed, total, completed >= total);
        startTimer(panel, Number(panel.dataset.remainingSeconds || 0));

        panel.querySelector('.mark-set-btn').addEventListener('click', function () {
            saveProgress(panel, Math.min(total, Number(panel.dataset.completedSets) + 1));
        });
        panel.querySelector('.undo-set-btn').addEventListener('click', function () {
            stopTimer(panel);
            saveProgress(panel, Math.max(0, Number(panel.dataset.completedSets) - 1));
        });
    });
});
</script>
@endpush
