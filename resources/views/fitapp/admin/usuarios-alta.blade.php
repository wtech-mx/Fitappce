@extends('layouts.fitapp-admin')

@section('title', 'Alta de usuario | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Alta de usuario</h1>
        <div class="admin-topbar-subtitle">Registro visual para crear usuarios desde administracion y dejar listo su perfil inicial.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button class="btn btn-primary-custom px-4">Guardar usuario</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-create-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Datos personales</h2>
                <div class="admin-mini">Informacion basica para contacto y expediente.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre completo</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Josue Hernandez">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Edad</label>
                        <input type="text" class="form-control input-soft" placeholder="28">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Genero</label>
                        <select class="form-select input-soft">
                            <option>Masculino</option>
                            <option>Femenino</option>
                            <option>Prefiere no decir</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Correo</label>
                        <input type="text" class="form-control input-soft" placeholder="usuario@email.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Telefono / WhatsApp</label>
                        <input type="text" class="form-control input-soft" placeholder="+52 000 000 0000">
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Objetivo y servicio</h2>
                <div class="admin-mini">Puede venir del onboarding o capturarse directo por el administrador.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Objetivo</label>
                        <select class="form-select input-soft">
                            <option>Aumento de masa muscular</option>
                            <option>Disminuir grasa corporal</option>
                            <option>Capacidad fisica condicional</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Servicio</label>
                        <select class="form-select input-soft">
                            <option>Entrenamiento</option>
                            <option>Plan alimentario</option>
                            <option selected>Rutina + nutricion</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tipo de plan</label>
                        <select class="form-select input-soft">
                            <option>Predefinido</option>
                            <option selected>Personalizado mensual</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nivel</label>
                        <select class="form-select input-soft">
                            <option>Principiante</option>
                            <option selected>Intermedio</option>
                            <option>Avanzado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dias de entrenamiento</label>
                        <select class="form-select input-soft">
                            <option>3 dias</option>
                            <option selected>4 dias</option>
                            <option>5 dias</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Lugar</label>
                        <select class="form-select input-soft">
                            <option selected>Gimnasio</option>
                            <option>Casa</option>
                            <option>Mixto</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Lesiones, enfermedades o contraindicaciones</label>
                        <textarea class="form-control input-soft py-3" rows="3" placeholder="Rodilla, lumbar, hombro, hipertension, diabetes, medicamentos, etc."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Nutricion inicial</h2>
                <div class="admin-mini">Datos para preparar el plan alimentario despues de la valoracion.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Comidas al dia</label>
                        <select class="form-select input-soft">
                            <option>3 comidas</option>
                            <option>4 comidas</option>
                            <option selected>5 comidas</option>
                            <option>6 comidas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Restriccion</label>
                        <select class="form-select input-soft">
                            <option selected>Ninguna</option>
                            <option>Sin lactosa</option>
                            <option>Sin gluten</option>
                            <option>Vegetariano</option>
                            <option>Personalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Horario dificil</label>
                        <select class="form-select input-soft">
                            <option>Manana</option>
                            <option>Mediodia</option>
                            <option>Tarde</option>
                            <option>Noche</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Alimentos que no quiere incluir</label>
                        <textarea class="form-control input-soft py-3" rows="3" placeholder="Ej. atun, huevo, lacteos, picante, etc."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Asignacion inicial</h2>
                <div class="admin-mini">Puedes dejarlo pendiente o asignar plan desde ahora.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Estado</label>
                    <select class="form-select input-soft">
                        <option>Prospecto</option>
                        <option selected>Activo</option>
                        <option>Pendiente de cita</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Plan de entrenamiento</label>
                    <select class="form-select input-soft">
                        <option>Pendiente</option>
                        <option>Masa muscular - Base 8 semanas</option>
                        <option>Personalizado mensual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Plan alimentario</label>
                    <select class="form-select input-soft">
                        <option>Pendiente</option>
                        <option>2168 kcal - 5 comidas</option>
                        <option>Definicion - 1800 kcal</option>
                    </select>
                </div>
                <button class="btn btn-primary-custom w-100">Crear usuario</button>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Despues se conectara</div>
            <div class="admin-mini">
                Esta vista sera el formulario real de alta. Por ahora sirve para validar que campos necesita el admin antes de crear registros.
            </div>
        </div>
    </div>
</div>
@endsection
