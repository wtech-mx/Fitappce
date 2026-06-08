@extends('layouts.fitapp')

@section('title', 'Tu vitrina | FitApp')

@section('content')
@php
    $unlockedCount = $achievements->filter(fn ($achievement) => optional($userAchievements->get($achievement->id))->unlocked_at)->count();
    $totalCount = $achievements->count();
    $percentage = $totalCount ? round(($unlockedCount / $totalCount) * 100) : 0;
@endphp

<div class="section-pad trophy-page">
    <div class="app-bar">
        <a href="{{ route('fitapp.progreso') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Tu vitrina</span>
    </div>

    <div class="trophy-hero mb-4">
        <div>
            <div class="page-kicker text-white mb-1">
                <i class="bi bi-stars"></i> Coleccionables
            </div>
            <h1 class="fit-title text-white mb-2">Tu vitrina de logros</h1>
            <p class="text-white-50 mb-0">
                Cada trofeo se desbloquea cuando cumples una meta marcada por tu coach.
            </p>
        </div>
        <div class="trophy-progress-ring">
            <strong>{{ $percentage }}%</strong>
            <span>{{ $unlockedCount }}/{{ $totalCount }}</span>
        </div>
    </div>

    @if($achievements->isEmpty())
        <div class="coach-note-box">
            <div class="fw-bold mb-2">Aun no hay logros disponibles</div>
            <div class="fit-subtitle mb-0">Tu coach pronto agregara los primeros trofeos a tu vitrina.</div>
        </div>
    @else
        @include('fitapp.partials.achievement-shelf', [
            'achievements' => $achievements,
            'userAchievements' => $userAchievements,
        ])
    @endif
</div>

@foreach($achievements as $achievement)
    @php
        $clientAchievement = $userAchievements->get($achievement->id);
        $isUnlocked = filled($clientAchievement?->unlocked_at);
    @endphp

    <div class="modal fade modal-fitapp" id="achievementModal{{ $achievement->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">{{ $achievement->name }}</h5>
                        <div class="small text-muted">{{ $achievement->categoryLabel() }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="achievement-modal-art {{ $isUnlocked ? 'is-unlocked' : 'is-locked' }}">
                        @if($achievement->imageUrl())
                            <img src="{{ $achievement->imageUrl() }}" alt="{{ $achievement->name }}">
                        @else
                            <i class="bi bi-trophy-fill"></i>
                        @endif
                    </div>

                    <div class="surface-card p-3 mb-3">
                        <div class="fw-bold mb-2">Meta</div>
                        <div class="fit-subtitle mb-0">{{ $achievement->goal_text }}</div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="routine-meta-pill">
                            <i class="bi bi-sliders"></i> {{ $achievement->triggerLabel() }}
                        </span>
                        @if($achievement->target_count)
                            <span class="routine-meta-pill">
                                <i class="bi bi-bullseye"></i> {{ $achievement->target_count }} {{ $achievement->target_unit }}
                            </span>
                        @endif
                    </div>

                    @if($isUnlocked)
                        <div class="exercise-evidence-box">
                            <div class="fw-bold">Desbloqueado</div>
                            <div class="small text-muted">
                                {{ $clientAchievement->unlocked_at->format('d/m/Y') }} - {{ $clientAchievement->source_note ?: 'Meta completada' }}
                            </div>
                        </div>
                    @else
                        <div class="coach-note-box mb-0">
                            <div class="fw-bold mb-1">Aun bloqueado</div>
                            <div class="fit-subtitle mb-0">Completa la meta para desbloquear este trofeo en tu vitrina.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
