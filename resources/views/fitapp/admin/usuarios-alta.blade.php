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
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-person-plus-fill me-2 text-primary-custom"></i>Alta de usuario</h1>
        <div class="admin-topbar-subtitle">Registro visual para crear usuarios desde administracion y dejar listo su perfil inicial.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios') }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Volver</a>
        <a href="{{ route('fitapp.admin.usuarios.detalle') }}" class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> Guardar usuario</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

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
                        <input type="text" class="form-control input-soft" placeholder="Ej. Josue Hernandez">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar3"></i>Edad</label>
                        <input type="text" class="form-control input-soft" placeholder="28">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-lines-fill"></i>Genero</label>
                        <select class="form-select input-soft">
                            <option>Masculino</option>
                            <option>Femenino</option>
                            <option>Prefiere no decir</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-envelope"></i>Correo</label>
                        <input type="text" class="form-control input-soft" placeholder="usuario@email.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-whatsapp"></i>Telefono / WhatsApp</label>
                        <input type="text" class="form-control input-soft" placeholder="+52 000 000 0000">
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
                        <select class="form-select input-soft">
                            <option>Aumento de masa muscular</option>
                            <option>Disminuir grasa corporal</option>
                            <option>Capacidad fisica condicional</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-grid-1x2"></i>Servicio</label>
                        <select class="form-select input-soft">
                            <option>Entrenamiento</option>
                            <option>Plan alimentario</option>
                            <option selected>Rutina + nutricion</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-clipboard2-pulse"></i>Tipo de plan</label>
                        <select class="form-select input-soft">
                            <option>Predefinido</option>
                            <option selected>Personalizado mensual</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-bar-chart-steps"></i>Nivel</label>
                        <select class="form-select input-soft">
                            <option>Principiante</option>
                            <option selected>Intermedio</option>
                            <option>Avanzado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-week"></i>Dias de entrenamiento</label>
                        <select class="form-select input-soft">
                            <option>3 dias</option>
                            <option selected>4 dias</option>
                            <option>5 dias</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-geo-alt"></i>Lugar</label>
                        <select class="form-select input-soft">
                            <option selected>Gimnasio</option>
                            <option>Casa</option>
                            <option>Mixto</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-shield-plus"></i>Lesiones, enfermedades o contraindicaciones</label>
                        <textarea class="form-control input-soft py-3" rows="3" placeholder="Rodilla, lumbar, hombro, hipertension, diabetes, medicamentos, etc."></textarea>
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
                        <select class="form-select input-soft">
                            <option>3 comidas</option>
                            <option>4 comidas</option>
                            <option selected>5 comidas</option>
                            <option>6 comidas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-slash-circle"></i>Restriccion</label>
                        <select class="form-select input-soft">
                            <option selected>Ninguna</option>
                            <option>Sin lactosa</option>
                            <option>Sin gluten</option>
                            <option>Vegetariano</option>
                            <option>Personalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-moon-stars"></i>Horario dificil</label>
                        <select class="form-select input-soft">
                            <option>Manana</option>
                            <option>Mediodia</option>
                            <option>Tarde</option>
                            <option>Noche</option>
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
                    <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="admin-btn-soft">
                        <i class="bi bi-rulers"></i> Captura completa
                    </a>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-speedometer2"></i>Peso corporal</label>
                        <input type="text" class="form-control input-soft" placeholder="65.30 kg">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-droplet-half"></i>Grasa corporal</label>
                        <input type="text" class="form-control input-soft" placeholder="14.73%">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-lightning-charge"></i>Masa magra</label>
                        <input type="text" class="form-control input-soft" placeholder="55.68 kg">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-arrows-collapse"></i>Cintura</label>
                        <input type="text" class="form-control input-soft" placeholder="81.20 cm">
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
                                <td><input class="form-control input-soft" placeholder="97.00 cm"></td>
                                <td><input class="form-control input-soft" placeholder="Meta"></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-universal-access me-2 text-primary-custom"></i>Cadera</td>
                                <td><input class="form-control input-soft" placeholder="92.50 cm"></td>
                                <td><input class="form-control input-soft" placeholder="Meta"></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-activity me-2 text-primary-custom"></i>Brazo flexionado</td>
                                <td><input class="form-control input-soft" placeholder="33.80 cm"></td>
                                <td><input class="form-control input-soft" placeholder="Meta"></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-arrow-down-up me-2 text-primary-custom"></i>Muslo</td>
                                <td><input class="form-control input-soft" placeholder="56.10 cm"></td>
                                <td><input class="form-control input-soft" placeholder="Meta"></td>
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
                    <select class="form-select input-soft">
                        <option>Prospecto</option>
                        <option selected>Activo</option>
                        <option>Pendiente de cita</option>
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
                    <a href="{{ route('fitapp.admin.usuarios.detalle') }}" class="btn btn-primary-custom w-100"><i class="bi bi-person-check-fill me-1"></i> Crear usuario</a>
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
    });
</script>
@endpush
