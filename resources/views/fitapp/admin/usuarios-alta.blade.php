@extends('layouts.fitapp-admin')

@section('title', 'Alta de usuario | FitCoach Admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    .select2-container{
        width:100% !important;
    }

    .select2-container--default .select2-selection--multiple{
        min-height:54px;
        border:1px solid transparent;
        border-radius:18px;
        background:var(--fa-soft);
        padding:8px 12px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple{
        border-color:var(--fa-primary);
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        border:0;
        border-radius:999px;
        background:#fff;
        box-shadow:0 8px 18px rgba(15,23,42,.08);
        color:var(--fa-dark);
        font-weight:700;
        padding:5px 10px 5px 24px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
        border:0;
        color:var(--fa-muted);
        left:7px;
        top:5px;
    }

    .select2-dropdown{
        border:1px solid var(--fa-border);
        border-radius:18px;
        overflow:hidden;
        box-shadow:var(--fa-shadow-md);
    }

    .food-blocked-list{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }

    .food-blocked-chip{
        display:inline-flex;
        align-items:center;
        gap:8px;
        border:1px solid var(--fa-border);
        border-radius:999px;
        padding:8px 12px;
        background:#fff;
        font-weight:800;
        box-shadow:0 10px 22px rgba(15,23,42,.06);
    }

    .food-blocked-chip i{
        color:var(--fa-danger);
    }
</style>
@endpush

@section('content')
@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $formAction = $isEdit ? route('fitapp.admin.usuarios.update', $user) : route('fitapp.admin.usuarios.store');
    $title = $isEdit ? 'Editar usuario' : 'Alta de usuario';
    $subtitle = $isEdit ? 'Actualiza datos base, expediente inicial y acceso del cliente.' : 'Registro visual para crear usuarios desde administracion y dejar listo su perfil inicial.';
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-person-plus-fill me-2 text-primary-custom"></i>{{ $title }}</h1>
        <div class="admin-topbar-subtitle">{{ $subtitle }}</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ $isEdit ? route('fitapp.admin.usuarios.detalle', $user) : route('fitapp.admin.usuarios') }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Volver</a>
        <button type="submit" form="userCreateForm" class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> {{ $isEdit ? 'Actualizar usuario' : 'Guardar usuario' }}</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ $formAction }}" id="userCreateForm">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

<div class="admin-create-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Datos personales</h2>
                        <div class="admin-mini">Informacion basica para contacto y expediente.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person"></i>Nombre completo</label>
                        <input type="text" class="form-control input-soft" name="name" value="{{ old('name', $user->name) }}" placeholder="Ej. Josue Hernandez" data-client-name-input required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar3"></i>Edad</label>
                        <input type="number" class="form-control input-soft" name="age" value="{{ old('age', $user->age) }}" placeholder="28" min="10" max="100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-lines-fill"></i>Genero</label>
                        <select class="form-select input-soft" name="gender">
                            <option value="Masculino" @selected(old('gender', $user->gender) === 'Masculino')>Masculino</option>
                            <option value="Femenino" @selected(old('gender', $user->gender) === 'Femenino')>Femenino</option>
                            <option value="Prefiere no decir" @selected(old('gender', $user->gender) === 'Prefiere no decir')>Prefiere no decir</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-envelope"></i>Correo</label>
                        <input type="email" class="form-control input-soft" name="email" value="{{ old('email', $user->email) }}" placeholder="usuario@email.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-whatsapp"></i>Telefono / WhatsApp</label>
                        <input type="tel" class="form-control input-soft" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="5544887799" inputmode="numeric" minlength="10" maxlength="10" pattern="[0-9]{10}" data-client-phone-input>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-key"></i>Contraseña inicial</label>
                        <input type="password" class="form-control input-soft" name="password" placeholder="{{ $isEdit ? 'Dejar vacia para conservarla' : 'Minimo 8 caracteres' }}" data-client-password-input @required(! $isEdit)>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-key-fill"></i>Confirmar contraseña</label>
                        <input type="password" class="form-control input-soft" name="password_confirmation" placeholder="{{ $isEdit ? 'Repite solo si cambias contraseña' : 'Repite la contraseña' }}" data-client-password-confirmation-input @required(! $isEdit)>
                    </div>
                    <div class="col-12">
                        <div class="admin-helper-note">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div>
                                    <div class="fw-bold mb-1">Contraseña sugerida</div>
                                    <div class="admin-mini">Se genera con el nombre y los ultimos 4 digitos del telefono.</div>
                                </div>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <code class="admin-password-suggestion" data-password-suggestion>Completa nombre y telefono</code>
                                    <button type="button" class="admin-btn-soft" data-use-password-suggestion>Usar</button>
                                    <button type="button" class="admin-btn-soft" data-copy-password-suggestion>Copiar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon success">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Objetivo y servicio</h2>
                        <div class="admin-mini">Puede venir del onboarding o capturarse directo por el administrador.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-trophy"></i>Objetivo</label>
                        <select class="form-select input-soft" name="goal">
                            <option value="Aumento de masa muscular" @selected(old('goal', $user->goal) === 'Aumento de masa muscular')>Aumento de masa muscular</option>
                            <option value="Disminuir grasa corporal" @selected(old('goal', $user->goal) === 'Disminuir grasa corporal')>Disminuir grasa corporal</option>
                            <option value="Capacidad fisica condicional" @selected(old('goal', $user->goal) === 'Capacidad fisica condicional')>Capacidad fisica condicional</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-grid-1x2"></i>Servicio</label>
                        <select class="form-select input-soft" name="service">
                            <option value="Entrenamiento" @selected(old('service', $user->service) === 'Entrenamiento')>Entrenamiento</option>
                            <option value="Plan alimentario" @selected(old('service', $user->service) === 'Plan alimentario')>Plan alimentario</option>
                            <option value="Rutina + nutricion" @selected(old('service', $user->service) === 'Rutina + nutricion')>Rutina + nutricion</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-clipboard2-pulse"></i>Tipo de plan</label>
                        <select class="form-select input-soft" name="plan_type">
                            <option value="Predefinido" @selected(old('plan_type', $user->plan_type) === 'Predefinido')>Predefinido</option>
                            <option value="Personalizado mensual" @selected(old('plan_type', $user->plan_type) === 'Personalizado mensual')>Personalizado mensual</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-bar-chart-steps"></i>Nivel</label>
                        <select class="form-select input-soft" name="training_level">
                            <option value="Principiante" @selected(old('training_level', $user->training_level) === 'Principiante')>Principiante</option>
                            <option value="Intermedio" @selected(old('training_level', $user->training_level) === 'Intermedio')>Intermedio</option>
                            <option value="Avanzado" @selected(old('training_level', $user->training_level) === 'Avanzado')>Avanzado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-week"></i>Dias de entrenamiento</label>
                        <select class="form-select input-soft" name="training_days">
                            <option value="3" @selected(old('training_days', $user->training_days) == 3)>3 dias</option>
                            <option value="4" @selected(old('training_days', $user->training_days) == 4)>4 dias</option>
                            <option value="5" @selected(old('training_days', $user->training_days) == 5)>5 dias</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-geo-alt"></i>Lugar</label>
                        <select class="form-select input-soft" name="training_place">
                            <option value="Gimnasio" @selected(old('training_place', $user->training_place) === 'Gimnasio')>Gimnasio</option>
                            <option value="Casa" @selected(old('training_place', $user->training_place) === 'Casa')>Casa</option>
                            <option value="Mixto" @selected(old('training_place', $user->training_place) === 'Mixto')>Mixto</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-shield-plus"></i>Lesiones, enfermedades o contraindicaciones</label>
                        <textarea class="form-control input-soft py-3" name="medical_notes" rows="3" placeholder="Rodilla, lumbar, hombro, hipertension, diabetes, medicamentos, etc.">{{ old('medical_notes', $user->medical_notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon accent">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Nutricion inicial</h2>
                        <div class="admin-mini">Datos para preparar el plan alimentario despues de la valoracion.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-clock-history"></i>Comidas al dia</label>
                        <select class="form-select input-soft" name="meals_per_day">
                            <option value="3" @selected(old('meals_per_day', $user->meals_per_day) == 3)>3 comidas</option>
                            <option value="4" @selected(old('meals_per_day', $user->meals_per_day) == 4)>4 comidas</option>
                            <option value="5" @selected(old('meals_per_day', $user->meals_per_day) == 5)>5 comidas</option>
                            <option value="6" @selected(old('meals_per_day', $user->meals_per_day) == 6)>6 comidas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-slash-circle"></i>Restriccion</label>
                        <select class="form-select input-soft" name="nutrition_restriction">
                            <option value="Ninguna" @selected(old('nutrition_restriction', $user->nutrition_restriction) === 'Ninguna')>Ninguna</option>
                            <option value="Sin lactosa" @selected(old('nutrition_restriction', $user->nutrition_restriction) === 'Sin lactosa')>Sin lactosa</option>
                            <option value="Sin gluten" @selected(old('nutrition_restriction', $user->nutrition_restriction) === 'Sin gluten')>Sin gluten</option>
                            <option value="Vegetariano" @selected(old('nutrition_restriction', $user->nutrition_restriction) === 'Vegetariano')>Vegetariano</option>
                            <option value="Personalizado" @selected(old('nutrition_restriction', $user->nutrition_restriction) === 'Personalizado')>Personalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-moon-stars"></i>Horario dificil</label>
                        <select class="form-select input-soft" name="difficult_schedule">
                            <option value="Manana" @selected(old('difficult_schedule', $user->difficult_schedule) === 'Manana')>Manana</option>
                            <option value="Mediodia" @selected(old('difficult_schedule', $user->difficult_schedule) === 'Mediodia')>Mediodia</option>
                            <option value="Tarde" @selected(old('difficult_schedule', $user->difficult_schedule) === 'Tarde')>Tarde</option>
                            <option value="Noche" @selected(old('difficult_schedule', $user->difficult_schedule) === 'Noche')>Noche</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-card-checklist"></i>Alimentos que no quiere incluir</label>
                    <select class="form-select input-soft" multiple data-food-exclusions-select>
                            @foreach($catalogs ?? [] as $catalog)
                                <optgroup label="{{ $catalog['name'] }}">
                                    @foreach($catalog['foods'] ?? [] as $food)
                                        <option
                                            value="{{ $food['id'] }}"
                                            @selected(in_array($food['id'], old('excluded_food_ids', $user->excluded_food_ids ?? [])))
                                            data-name="{{ $food['name'] }}"
                                            data-unit="{{ $food['base_unit'] }}"
                                            data-category="{{ $food['category'] }}"
                                        >
                                            {{ $food['name'] }} - {{ $food['base_unit'] }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                        <div class="admin-helper-note mt-3">
                            <div class="fw-bold mb-1"><i class="bi bi-ban me-1 text-danger"></i>Alimentos bloqueados para este usuario</div>
                            <div class="admin-mini mb-3">
                                Estos alimentos deben excluirse al crear su plan nutricional.
                            </div>
                            <div class="food-blocked-list" data-food-exclusions-list>
                                <div class="admin-mini" data-food-exclusions-empty>Sin alimentos seleccionados.</div>
                            </div>
                            <div data-food-exclusions-inputs></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div class="admin-section-heading">
                        <div class="admin-section-icon warn">
                            <i class="bi bi-rulers"></i>
                        </div>
                        <div>
                            <h2 class="admin-panel-title mb-1">Medicion inicial</h2>
                            <div class="admin-mini">Registro base para que el usuario vea su progreso corporal desde el primer dia.</div>
                        </div>
                    </div>
                    <a href="{{ $isEdit ? route('fitapp.admin.mediciones.crear', ['user' => $user->id]) : route('fitapp.admin.mediciones.crear') }}" class="admin-btn-soft">
                        <i class="bi bi-rulers"></i> Captura completa
                    </a>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-speedometer2"></i>Peso corporal</label>
                        <input type="number" step="0.01" class="form-control input-soft" name="initial_weight" value="{{ old('initial_weight', $user->initial_weight) }}" placeholder="65.30">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-droplet-half"></i>Grasa corporal</label>
                        <input type="number" step="0.01" class="form-control input-soft" name="initial_body_fat" value="{{ old('initial_body_fat', $user->initial_body_fat) }}" placeholder="14.73">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-lightning-charge"></i>Masa magra</label>
                        <input type="number" step="0.01" class="form-control input-soft" name="initial_lean_mass" value="{{ old('initial_lean_mass', $user->initial_lean_mass) }}" placeholder="55.68">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-arrows-collapse"></i>Cintura</label>
                        <input type="number" step="0.01" class="form-control input-soft" name="initial_waist" value="{{ old('initial_waist', $user->initial_waist) }}" placeholder="81.20">
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Perimetro clave</th>
                                <th>Actual</th>
                                <th>Meta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-person-arms-up me-2 text-primary-custom"></i>Pecho / torax</td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="initial_chest" value="{{ old('initial_chest', $user->initial_chest) }}" placeholder="97.00"></td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="goal_chest" value="{{ old('goal_chest', $user->goal_chest) }}" placeholder="Meta"></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-universal-access me-2 text-primary-custom"></i>Cadera</td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="initial_hip" value="{{ old('initial_hip', $user->initial_hip) }}" placeholder="92.50"></td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="goal_hip" value="{{ old('goal_hip', $user->goal_hip) }}" placeholder="Meta"></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-activity me-2 text-primary-custom"></i>Brazo flexionado</td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="initial_arm" value="{{ old('initial_arm', $user->initial_arm) }}" placeholder="33.80"></td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="goal_arm" value="{{ old('goal_arm', $user->goal_arm) }}" placeholder="Meta"></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-arrow-down-up me-2 text-primary-custom"></i>Muslo</td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="initial_thigh" value="{{ old('initial_thigh', $user->initial_thigh) }}" placeholder="56.10"></td>
                                <td><input type="number" step="0.01" class="form-control input-soft" name="goal_thigh" value="{{ old('goal_thigh', $user->goal_thigh) }}" placeholder="Meta"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="admin-helper-note mt-3">
                    <div class="fw-bold mb-1">Base del progreso</div>
                    <div class="admin-mini">
                        Estos datos alimentaran la vista del usuario en Progreso. Si necesitas pliegues, formulas y reporte completo, usa Captura completa.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon danger">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Asignacion inicial</h2>
                        <div class="admin-mini">Puedes dejarlo pendiente o asignar plan desde ahora.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold admin-label-icon"><i class="bi bi-toggle-on"></i>Estado</label>
                    <select class="form-select input-soft" name="status">
                        <option value="prospect" @selected(old('status', $user->status) === 'prospect')>Prospecto</option>
                        <option value="active" @selected(old('status', $user->status) === 'active')>Activo</option>
                        <option value="appointment_pending" @selected(old('status', $user->status) === 'appointment_pending')>Pendiente de cita</option>
                        <option value="paused" @selected(old('status', $user->status) === 'paused')>Pausado</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold admin-label-icon"><i class="bi bi-clipboard2-pulse"></i>Plan de entrenamiento</label>
                    <select class="form-select input-soft">
                        <option>Pendiente</option>
                        <option>Masa muscular - Base 8 semanas</option>
                        <option>Personalizado mensual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold admin-label-icon"><i class="bi bi-journal-medical"></i>Plan alimentario</label>
                    <select class="form-select input-soft">
                        <option>Pendiente</option>
                        <option>2168 kcal - 5 comidas</option>
                        <option>Definicion - 1800 kcal</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold admin-label-icon"><i class="bi bi-activity"></i>Rutina vinculada</label>
                    <select class="form-select input-soft">
                        <option>Pendiente</option>
                        <option selected>Masa muscular - Intermedio</option>
                        <option>Definicion - Casa</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('fitapp.admin.planes.crear') }}" class="btn btn-soft-custom w-100"><i class="bi bi-plus-circle me-1"></i> Crear plan nuevo</a>
                    <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="btn btn-soft-custom w-100"><i class="bi bi-plus-square me-1"></i> Crear rutina nueva</a>
                    <button type="submit" class="btn btn-primary-custom w-100"><i class="bi bi-person-check-fill me-1"></i> {{ $isEdit ? 'Actualizar usuario' : 'Crear usuario' }}</button>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-3"><i class="bi bi-signpost-split me-1 text-primary-custom"></i> Flujo correcto</div>
            <div class="admin-flow-list">
                <div class="admin-flow-item">
                    <div class="admin-flow-icon"><i class="bi bi-person-plus"></i></div>
                    <div>
                        <div class="fw-bold">Alta de usuario</div>
                        <div class="admin-mini">Datos base y expediente.</div>
                    </div>
                </div>
                <div class="admin-flow-item">
                    <div class="admin-flow-icon"><i class="bi bi-rulers"></i></div>
                    <div>
                        <div class="fw-bold">Medicion inicial</div>
                        <div class="admin-mini">Punto de partida del progreso.</div>
                    </div>
                </div>
                <div class="admin-flow-item">
                    <div class="admin-flow-icon"><i class="bi bi-clipboard2-check"></i></div>
                    <div>
                        <div class="fw-bold">Plan y rutina</div>
                        <div class="admin-mini">Rutinas, dias y ejercicios vinculados.</div>
                    </div>
                </div>
                <div class="admin-flow-item">
                    <div class="admin-flow-icon"><i class="bi bi-phone"></i></div>
                    <div>
                        <div class="fw-bold">Perfil usuario</div>
                        <div class="admin-mini">Progreso corporal visible en app.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.querySelector('[data-food-exclusions-select]');
        const list = document.querySelector('[data-food-exclusions-list]');
        const empty = document.querySelector('[data-food-exclusions-empty]');
        const inputs = document.querySelector('[data-food-exclusions-inputs]');
        const clientName = document.querySelector('[data-client-name-input]');
        const clientPhone = document.querySelector('[data-client-phone-input]');
        const password = document.querySelector('[data-client-password-input]');
        const passwordConfirmation = document.querySelector('[data-client-password-confirmation-input]');
        const suggestion = document.querySelector('[data-password-suggestion]');
        const useSuggestion = document.querySelector('[data-use-password-suggestion]');
        const copySuggestion = document.querySelector('[data-copy-password-suggestion]');

        if (window.jQuery && jQuery.fn.select2 && select) {
            jQuery(select).select2({
                placeholder: 'Buscar y seleccionar alimentos...',
                width: '100%',
                closeOnSelect: false,
            });
        }

        const renderExclusions = () => {
            if (!select || !list || !inputs) {
                return;
            }

            const selected = Array.from(select.selectedOptions);
            list.querySelectorAll('.food-blocked-chip').forEach((chip) => chip.remove());
            inputs.replaceChildren();

            if (empty) {
                empty.classList.toggle('d-none', selected.length > 0);
            }

            selected.forEach((option) => {
                const chip = document.createElement('div');
                chip.className = 'food-blocked-chip';
                chip.innerHTML = `<i class="bi bi-ban"></i><span></span>`;
                chip.querySelector('span').textContent = `${option.dataset.name || option.text} (${option.dataset.unit || 'porcion'})`;
                list.appendChild(chip);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'excluded_food_ids[]';
                input.value = option.value;
                inputs.appendChild(input);
            });
        };

        select?.addEventListener('change', renderExclusions);

        if (window.jQuery) {
            jQuery(select).on('select2:select select2:unselect change', renderExclusions);
        }

        renderExclusions();

        const normalizeWord = (value) => value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z]/g, '');

        const getSuggestedPassword = () => {
            const parts = (clientName?.value || '')
                .trim()
                .split(/\s+/)
                .map(normalizeWord)
                .filter((part) => part.length >= 2);
            const phone = (clientPhone?.value || '').replace(/\D/g, '');

            if (parts.length < 2 || phone.length < 10) {
                return '';
            }

            return `${parts[0].slice(-2)}${parts[1].slice(-2)}${phone.slice(-4)}`;
        };

        const renderPasswordSuggestion = () => {
            const value = getSuggestedPassword();

            if (suggestion) {
                suggestion.textContent = value || 'Completa nombre y telefono';
            }

            useSuggestion?.toggleAttribute('disabled', !value);
            copySuggestion?.toggleAttribute('disabled', !value);
        };

        clientPhone?.addEventListener('input', () => {
            clientPhone.value = clientPhone.value.replace(/\D/g, '').slice(0, 10);
            renderPasswordSuggestion();
        });

        clientName?.addEventListener('input', renderPasswordSuggestion);

        useSuggestion?.addEventListener('click', () => {
            const value = getSuggestedPassword();

            if (!value) {
                return;
            }

            if (password) {
                password.value = value;
            }

            if (passwordConfirmation) {
                passwordConfirmation.value = value;
            }
        });

        copySuggestion?.addEventListener('click', async () => {
            const value = getSuggestedPassword();

            if (!value || !navigator.clipboard) {
                return;
            }

            await navigator.clipboard.writeText(value);
            copySuggestion.textContent = 'Copiado';
            setTimeout(() => {
                copySuggestion.textContent = 'Copiar';
            }, 1600);
        });

        renderPasswordSuggestion();
    });
</script>
@endpush
