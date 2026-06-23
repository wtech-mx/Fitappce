@php
    $demoUrl = $exercise?->demoUrl();
    $embedUrl = $exercise?->demoEmbedUrl();
    $isImage = $exercise && ($exercise->demo_type === 'image' || str_ends_with(strtolower((string) $exercise->demo_path), '.gif'));
@endphp

@if($embedUrl)
    <iframe src="{{ $embedUrl }}" class="exercise-demo-media" title="{{ $exercise->name }}" allowfullscreen></iframe>
@elseif($demoUrl)
    @if($isImage)
        <img src="{{ $demoUrl }}" alt="{{ $exercise->name }}" class="exercise-demo-media">
    @elseif($exercise->demo_source === 'upload')
        <video src="{{ $demoUrl }}" controls preload="metadata" playsinline class="exercise-demo-media"></video>
    @else
        <div>
            <i class="bi bi-box-arrow-up-right"></i>
            <div class="fw-bold mb-2">Demo externo</div>
            <a href="{{ $demoUrl }}" target="_blank" rel="noopener" class="btn btn-primary-custom">
                Abrir video
            </a>
        </div>
    @endif
@else
    <div>
        <i class="bi bi-play-circle-fill"></i>
        <div class="fw-bold mb-1">{{ $emptyTitle ?? 'Sin demo cargado' }}</div>
        @if(!empty($emptyText))
            <div class="small text-muted">{{ $emptyText }}</div>
        @endif
    </div>
@endif
