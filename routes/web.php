<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\NutritionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fitapp/auth')->name('home');
Route::redirect('/login', '/fitapp/auth')->name('login');
Route::redirect('/register', '/fitapp/auth')->name('register');
Route::redirect('/dashboard', '/fitapp/dashboard')->name('dashboard');

Route::prefix('fitapp')->name('fitapp.')->group(function () {
    Route::view('/splash', 'fitapp.splash')->name('splash');
    Route::get('/auth', [AuthController::class, 'show'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('onboarding')->name('onboarding.')->middleware(['auth', 'role:user,admin'])->group(function () {
        Route::redirect('/', '/fitapp/onboarding/bienvenida')->name('index');
        Route::view('/bienvenida', 'fitapp.onboarding.welcome')->name('welcome');
        Route::view('/objetivo', 'fitapp.onboarding.goal')->name('goal');
        Route::view('/servicio', 'fitapp.onboarding.service')->name('service');
        Route::view('/entrenamiento', 'fitapp.onboarding.training')->name('training');
        Route::view('/nutricion', 'fitapp.onboarding.nutrition')->name('nutrition');
        Route::view('/cita', 'fitapp.onboarding.appointment')->name('appointment');
        Route::view('/gracias', 'fitapp.onboarding.thankyou')->name('thankyou');
    });

    Route::middleware(['auth', 'role:user,admin'])->group(function () {
        Route::view('/dashboard', 'fitapp.dashboard')->name('dashboard');
        Route::view('/rutina', 'fitapp.rutina')->name('rutina');
        Route::view('/rutina-dia', 'fitapp.rutina-dia')->name('rutina-dia');
        Route::view('/nutricion-diaria', 'fitapp.nutricion')->name('nutricion');

        Route::view('/plan-alimentario', 'fitapp.plan-alimentario')->name('plan');
        Route::view('/recetas', 'fitapp.recetas')->name('recetas');
        Route::view('/progreso', 'fitapp.progreso-corporal')->name('progreso');
        Route::redirect('/progreso-corporal', '/fitapp/progreso')->name('progreso-corporal');
        Route::view('/perfil', 'fitapp.perfil')->name('perfil');
    });
});

Route::prefix('admin')->name('fitapp.admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('/', '/admin/dashboard')->name('index');
    Route::view('/dashboard', 'fitapp.admin.dashboard')->name('dashboard');
    Route::view('/citas', 'fitapp.admin.citas')->name('citas');
    Route::view('/usuarios', 'fitapp.admin.usuarios')->name('usuarios');
    Route::get('/usuarios/alta', [UserController::class, 'create'])->name('usuarios.alta');
    Route::view('/usuarios/detalle', 'fitapp.admin.usuario-detalle')->name('usuarios.detalle');
    Route::view('/mediciones', 'fitapp.admin.mediciones')->name('mediciones');
    Route::view('/mediciones/crear', 'fitapp.admin.mediciones-crear')->name('mediciones.crear');
    Route::view('/mediciones/reporte', 'fitapp.admin.mediciones-reporte')->name('mediciones.reporte');
    Route::view('/planes', 'fitapp.admin.planes')->name('planes');
    Route::view('/planes/crear', 'fitapp.admin.planes-crear')->name('planes.crear');
    Route::view('/planes/detalle', 'fitapp.admin.plan-detalle')->name('planes.detalle');
    Route::view('/rutinas', 'fitapp.admin.rutinas')->name('rutinas');
    Route::view('/rutinas/crear', 'fitapp.admin.rutinas-crear')->name('rutinas.crear');
    Route::view('/rutinas/detalle', 'fitapp.admin.rutina-detalle')->name('rutinas.detalle');
    Route::view('/ejercicios', 'fitapp.admin.ejercicios')->name('ejercicios');
    Route::view('/ejercicios/crear', 'fitapp.admin.ejercicios-crear')->name('ejercicios.crear');
    Route::view('/ejercicios/detalle', 'fitapp.admin.ejercicio-detalle')->name('ejercicios.detalle');
    Route::view('/evidencias', 'fitapp.admin.evidencias')->name('evidencias');
    Route::view('/nutricion', 'fitapp.admin.nutricion')->name('nutricion');
    Route::get('/nutricion/crear', [NutritionController::class, 'create'])->name('nutricion.crear');
    Route::view('/pagos', 'fitapp.admin.pagos')->name('pagos');
    Route::view('/configuracion', 'fitapp.admin.configuracion')->name('configuracion');
});
