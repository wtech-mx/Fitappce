@extends('layouts.fitapp')

@section('title', 'Splash | FitApp')

@section('content')
<div class="section-pad d-flex flex-column justify-content-between bg-dark-custom" style="min-height:100vh;">
    <div class="pt-4">
        <span class="badge rounded-pill bg-accent-custom px-3 py-2 fw-bold">
            Fitness & Nutrición
        </span>
    </div>

    <div class="text-center py-5">
        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-primary-custom"
             style="width:110px;height:110px;">
            <i class="bi bi-heart-pulse-fill fs-1"></i>
        </div>

        <h1 class="fw-bold mb-3" style="font-size:2.2rem;">FitCoach</h1>
        <p class="mb-0 text-white-50 px-3">
            Tu entrenamiento, tu nutrición y tu progreso en una sola app.
        </p>
    </div>

    <div class="pb-4">
        <a href="{{ route('fitapp.auth') }}" class="btn btn-accent-custom w-100">
            Comenzar
        </a>
    </div>
</div>
@endsection
