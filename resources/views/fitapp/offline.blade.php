@extends('layouts.fitapp')

@section('title', 'Sin conexion | FitApp')

@section('content')
<div class="section-pad d-flex align-items-center" style="min-height:100dvh;">
    <div class="surface-card p-4 text-center w-100">
        <div class="exercise-thumb mx-auto mb-3"><i class="bi bi-cloud-slash"></i></div>
        <h1 class="fit-title mb-2">Estas sin conexion</h1>
        <p class="fit-subtitle mb-4">Puedes continuar en las rutinas que ya abriste. Tus series se guardaran en este dispositivo y se sincronizaran al recuperar internet.</p>
        <button type="button" class="btn btn-primary-custom w-100" onclick="window.location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i> Intentar de nuevo
        </button>
    </div>
</div>
@endsection
