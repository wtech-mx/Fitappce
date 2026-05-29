@extends('layouts.fitapp')

@section('title', 'Plan alimentario | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.nutricion') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <a href="{{ route('fitapp.recetas') }}" class="app-bar-btn text-dark">
            <i class="bi bi-book"></i>
        </a>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-journal-text"></i> Nutricion
        </div>
        <h1 class="fit-title mb-2">Tu plan alimentario</h1>
        <p class="fit-subtitle mb-0">
            {{ $activePlan ? $activePlan->name : 'Tu coach aun no ha asignado un plan activo.' }}
        </p>
    </div>

    <div class="hero-card hero-blue mb-4">
        <div class="row text-center g-3">
            <div class="col-4">
                <div class="fw-bold fs-5">{{ $activePlan ? number_format((float) $activePlan->target_calories, 0) : '-' }}</div>
                <small class="text-white-50">Kcal</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">{{ $activePlan ? number_format((float) $activePlan->target_protein, 0).'g' : '-' }}</div>
                <small class="text-white-50">Proteina</small>
            </div>
            <div class="col-4">
                <div class="fw-bold fs-5">{{ $activePlan?->meals->count() ?: '-' }}</div>
                <small class="text-white-50">Comidas</small>
            </div>
        </div>
    </div>

    @if ($activePlan)
        <div class="d-grid gap-3 mb-4">
            @foreach ($activePlan->meals as $meal)
                <div class="day-card p-3">
                    <div class="fw-bold mb-1">{{ $meal->name }}</div>
                    <div class="fit-subtitle">
                        {{ $meal->items->pluck('food_name')->join(' + ') ?: 'Sin alimentos capturados' }}
                    </div>
                    @if ($meal->items->isNotEmpty())
                        <div class="soft-divider"></div>
                        <div class="d-grid gap-2">
                            @foreach ($meal->items as $item)
                                <div class="d-flex justify-content-between gap-3">
                                    <span>{{ $item->food_name }}</span>
                                    <strong>{{ number_format((float) $item->quantity, 0) }} {{ $item->unit }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="surface-card p-4 mb-4">
            <div class="fw-bold mb-3">Indicaciones del entrenador</div>
            <ul class="info-list mb-0">
                <li>Agua diaria: {{ $activePlan->daily_water ?: 'Pendiente' }}</li>
                <li>Carbohidratos: {{ number_format((float) $activePlan->target_carbohydrates, 0) }} g</li>
                <li>Grasas: {{ number_format((float) $activePlan->target_fat, 0) }} g</li>
                @if ($activePlan->notes)
                    <li>{{ $activePlan->notes }}</li>
                @endif
            </ul>
        </div>
    @else
        <div class="surface-card p-4 mb-4">
            <div class="fw-bold mb-2">Plan pendiente</div>
            <div class="fit-subtitle">Cuando tu coach active tu plan alimentario, aparecera aqui con comidas, porciones y notas.</div>
        </div>
    @endif

    <a href="{{ route('fitapp.recetas') }}" class="btn btn-primary-custom w-100">
        Ver recetas sugeridas
    </a>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
