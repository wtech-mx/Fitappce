@php
    $compact = $compact ?? false;
@endphp

@if($achievements->isEmpty())
    <div class="coach-note-box mb-0">
        <div class="fw-bold mb-2">Aun no hay logros disponibles</div>
        <div class="fit-subtitle mb-0">Tu coach pronto agregara los primeros trofeos.</div>
    </div>
@else
    <div class="trophy-cabinet {{ $compact ? 'is-compact' : '' }}">
        @foreach($achievements as $achievement)
            @php
                $clientAchievement = $userAchievements->get($achievement->id);
                $isUnlocked = filled($clientAchievement?->unlocked_at);
            @endphp

            <button type="button" class="trophy-piece {{ $isUnlocked ? 'is-unlocked' : 'is-locked' }}" data-bs-toggle="modal" data-bs-target="#achievementModal{{ $achievement->id }}">
                <span class="trophy-piece-art">
                    @if($achievement->imageUrl())
                        <img src="{{ $achievement->imageUrl() }}" alt="{{ $achievement->name }}">
                    @else
                        <i class="bi bi-trophy-fill"></i>
                    @endif
                </span>
                <span class="trophy-piece-title">{{ $achievement->name }}</span>
                <span class="trophy-piece-status">{{ $isUnlocked ? 'Ganado' : 'Bloqueado' }}</span>
            </button>
        @endforeach
    </div>
@endif
