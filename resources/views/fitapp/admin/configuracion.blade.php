@extends('layouts.fitapp-admin')

@section('title', 'Configuración | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Configuración</h1>
        <div class="admin-topbar-subtitle">Ajustes visuales del negocio, agenda, servicios, pagos y reglas de seguimiento.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-primary-custom px-4">Guardar cambios</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-7">
        <div class="admin-form-card mb-3">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Datos del consultorio</h2>
                <div class="admin-mini">Información que verá el usuario al reservar valoración.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre comercial</label>
                        <input type="text" class="form-control input-soft" value="FitCoach">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">WhatsApp de contacto</label>
                        <input type="text" class="form-control input-soft" value="+52 000 000 0000">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Dirección del consultorio</label>
                        <textarea class="form-control input-soft py-3" rows="3" placeholder="Calle, número, colonia, ciudad y referencias."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">URL de mapa</label>
                        <input type="text" class="form-control input-soft" placeholder="https://maps.google.com/...">
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card mb-3">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Servicios disponibles</h2>
                <div class="admin-mini">Estos servicios conectan con el onboarding y el panel de usuarios.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Plan de entrenamiento</div>
                                <div class="small text-muted">Rutinas preconfiguradas o personalizadas.</div>
                            </div>
                            <div class="admin-toggle-demo is-on"></div>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Plan alimentario</div>
                                <div class="small text-muted">Comidas, macros, agua y evidencia fotográfica.</div>
                            </div>
                            <div class="admin-toggle-demo is-on"></div>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Paquete completo</div>
                                <div class="small text-muted">Entrenamiento, nutrición, cita y seguimiento.</div>
                            </div>
                            <div class="admin-toggle-demo is-on"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Objetivos del onboarding</h2>
                <div class="admin-mini">Opciones iniciales que verá el usuario al empezar.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Objetivo 1</label>
                        <input type="text" class="form-control input-soft" value="Aumento de masa muscular">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Objetivo 2</label>
                        <input type="text" class="form-control input-soft" value="Capacidad física condicional">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Objetivo 3</label>
                        <input type="text" class="form-control input-soft" value="Disminuir grasa corporal">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="admin-form-card mb-3">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Agenda</h2>
                <div class="admin-mini">Bloques visuales para disponibilidad de cita.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-bold">Duración de cita</label>
                        <select class="form-select input-soft">
                            <option>30 minutos</option>
                            <option selected>45 minutos</option>
                            <option>60 minutos</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Apartado</label>
                        <input type="text" class="form-control input-soft" value="$100 MXN">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Horarios base</label>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="admin-tag blue">10:00 AM</span>
                            <span class="admin-tag blue">11:00 AM</span>
                            <span class="admin-tag blue">12:30 PM</span>
                            <span class="admin-tag">04:00 PM</span>
                            <span class="admin-tag">05:30 PM</span>
                            <span class="admin-tag">06:30 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card mb-3">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Planes personalizados</h2>
                <div class="admin-mini">Reglas para renovación y seguimiento mensual.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Renovación mensual</div>
                                <div class="small text-muted">El plan personalizado cambia mes a mes.</div>
                            </div>
                            <div class="admin-toggle-demo is-on"></div>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Evidencia obligatoria</div>
                                <div class="small text-muted">Fotos de comida y videos de técnica.</div>
                            </div>
                            <div class="admin-toggle-demo is-on"></div>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Mediciones corporales</div>
                                <div class="small text-muted">Peso, grasa, pliegues y perímetros.</div>
                            </div>
                            <div class="admin-toggle-demo is-on"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Pendiente para backend</div>
            <div class="admin-mini">
                Cuando terminemos las vistas, estos campos se convertirán en tablas, validaciones y formularios reales. Por ahora queda todo simulado para revisar navegación y experiencia.
            </div>
        </div>
    </div>
</div>
@endsection
