@extends('layouts.fitapp')

@section('title', 'Fotos de progreso | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.dashboard') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Fotos</span>
    </div>

    @if (session('status'))
        <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
    @endif

    <div class="hero-card hero-dark mb-4">
        <div class="page-kicker text-white mb-2"><i class="bi bi-camera"></i> Avance para tu coach</div>
        <h1 class="h4 fw-bold mb-2">Fotos de progreso</h1>
        <p class="text-white-50 mb-0">
            @if($nextAppointment)
                Tu proxima cita es el {{ $nextAppointment->starts_at->format('d/m/Y') }}. Puedes subir fotos desde el {{ $uploadWindow['starts_at']?->format('d/m/Y') }}.
            @else
                Cuando tengas una cita programada, aqui podras enviar tus fotos de avance.
            @endif
        </p>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="fw-bold">Subir fotos</div>
                <div class="fit-subtitle">Puedes seleccionar varias. La app las optimiza para que no pesen tanto.</div>
            </div>
            <span class="status-pill {{ $uploadWindow['is_open'] ? 'status-ok' : 'status-warn' }}">{{ $uploadWindow['is_open'] ? 'Abierto' : 'Cerrado' }}</span>
        </div>

        @if(! $uploadWindow['is_open'])
            <div class="coach-note-box mb-3">
                {{ $uploadWindow['reason'] }}
            </div>
        @endif

        <form method="POST" action="{{ route('fitapp.fotos-progreso.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Fotos</label>
                <input type="file" name="photos[]" class="form-control input-soft" accept="image/jpeg,image/png,image/webp" multiple {{ $uploadWindow['is_open'] ? '' : 'disabled' }}>
                <div class="mini-note mt-2">Formatos: JPG, PNG o WebP. Si tu iPhone toma HEIC, cambia a formato mas compatible o envia una version JPG.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Comentario opcional</label>
                <textarea name="notes" class="form-control input-soft" rows="3" placeholder="Ej. Fotos en ayunas, misma luz, mismas poses..." {{ $uploadWindow['is_open'] ? '' : 'disabled' }}></textarea>
            </div>

            <button class="btn btn-primary-custom w-100" {{ $uploadWindow['is_open'] ? '' : 'disabled' }}>
                Subir fotos
            </button>
        </form>
    </div>

    <div class="surface-card p-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="fw-bold">Fotos enviadas</div>
                <div class="fit-subtitle">{{ $photos->count() }} foto(s) registradas.</div>
            </div>
            <i class="bi bi-images fs-5 text-primary-custom"></i>
        </div>

        @if($photos->isEmpty())
            <div class="fit-subtitle">Aun no has enviado fotos de progreso.</div>
        @else
            <div class="progress-photo-grid">
                @foreach($photos as $photo)
                    <div class="progress-photo-card">
                        <img src="{{ $photo->imageUrl() }}" alt="Foto de progreso">
                        <div class="progress-photo-meta">
                            <strong>{{ $photo->created_at->format('d/m/Y') }}</strong>
                            <span>{{ $photo->savedPercent() }}% menos peso</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
