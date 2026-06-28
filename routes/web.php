<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientProgressController;
use App\Http\Controllers\ClientProgressPhotoController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\ClientNutritionController;
use App\Http\Controllers\ClientWorkoutController;
use App\Http\Controllers\ClientAchievementController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ExerciseMediaController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\NutritionController;
use App\Http\Controllers\Admin\MeasurementController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/fitapp/auth')->name('home');
Route::redirect('/login', '/fitapp/auth')->name('login');
Route::redirect('/register', '/fitapp/auth')->name('register');
Route::redirect('/dashboard', '/fitapp/dashboard')->name('dashboard');

Route::prefix('fitapp')->name('fitapp.')->group(function () {
    Route::view('/offline', 'fitapp.offline')->name('offline');
    Route::get('/ejercicios/{exercise}/demo', ExerciseMediaController::class)->name('exercise-demo');
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
        Route::get('/sync-context', [ClientWorkoutController::class, 'syncContext'])->name('sync-context');
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/rutina', [ClientWorkoutController::class, 'index'])->name('rutina');
        Route::get('/rutina-dia/{day?}', [ClientWorkoutController::class, 'day'])->name('rutina-dia');
        Route::put('/rutina-dia/{day}/progreso', [ClientWorkoutController::class, 'updateProgress'])->name('rutina-dia.progreso');
        Route::get('/nutricion-diaria', [ClientNutritionController::class, 'daily'])->name('nutricion');

        Route::get('/plan-alimentario', [ClientNutritionController::class, 'plan'])->name('plan');
        Route::view('/recetas', 'fitapp.recetas')->name('recetas');
        Route::get('/progreso', [ClientProgressController::class, 'index'])->name('progreso');
        Route::get('/progreso-corporal', [ClientProgressController::class, 'report'])->name('progreso-corporal');
        Route::get('/fotos-progreso', [ClientProgressPhotoController::class, 'index'])->name('fotos-progreso');
        Route::post('/fotos-progreso', [ClientProgressPhotoController::class, 'store'])->name('fotos-progreso.store');
        Route::get('/logros', [ClientAchievementController::class, 'index'])->name('logros');
        Route::get('/perfil', [ClientProfileController::class, 'show'])->name('perfil');
        Route::put('/perfil/visual', [ClientProfileController::class, 'updateVisual'])->name('perfil.visual');
    });
});

Route::prefix('admin')->name('fitapp.admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('/', '/admin/dashboard')->name('index');
    Route::view('/dashboard', 'fitapp.admin.dashboard')->name('dashboard');
    Route::get('/citas', [AppointmentController::class, 'index'])->name('citas');
    Route::post('/citas', [AppointmentController::class, 'store'])->name('citas.store');
    Route::put('/citas/{appointment}', [AppointmentController::class, 'update'])->name('citas.update');
    Route::post('/citas/bloqueos', [AppointmentController::class, 'block'])->name('citas.bloqueos.store');
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/alta', [UserController::class, 'create'])->name('usuarios.alta');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
    Route::get('/usuarios/{user}/expediente', [UserController::class, 'record'])->name('usuarios.expediente');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('usuarios.detalle');
    Route::get('/mediciones', [MeasurementController::class, 'index'])->name('mediciones');
    Route::get('/mediciones/crear', [MeasurementController::class, 'create'])->name('mediciones.crear');
    Route::post('/mediciones', [MeasurementController::class, 'store'])->name('mediciones.store');
    Route::view('/mediciones/reporte', 'fitapp.admin.mediciones-reporte')->name('mediciones.reporte');
    Route::get('/planes', [PlanController::class, 'index'])->name('planes');
    Route::view('/planes/crear', 'fitapp.admin.planes-crear')->name('planes.crear');
    Route::view('/planes/detalle', 'fitapp.admin.plan-detalle')->name('planes.detalle');
    Route::get('/rutinas', [WorkoutController::class, 'index'])->name('rutinas');
    Route::get('/rutinas/crear', [WorkoutController::class, 'create'])->name('rutinas.crear');
    Route::post('/rutinas', [WorkoutController::class, 'store'])->name('rutinas.store');
    Route::get('/rutinas/{routine}', [WorkoutController::class, 'show'])->name('rutinas.detalle');
    Route::get('/rutinas/{routine}/editar', [WorkoutController::class, 'edit'])->name('rutinas.edit');
    Route::put('/rutinas/{routine}', [WorkoutController::class, 'update'])->name('rutinas.update');
    Route::get('/ejercicios', [ExerciseController::class, 'index'])->name('ejercicios');
    Route::get('/ejercicios/crear', [ExerciseController::class, 'create'])->name('ejercicios.crear');
    Route::post('/ejercicios', [ExerciseController::class, 'store'])->name('ejercicios.store');
    Route::get('/ejercicios/{exercise}', [ExerciseController::class, 'show'])->name('ejercicios.detalle');
    Route::get('/ejercicios/{exercise}/editar', [ExerciseController::class, 'edit'])->name('ejercicios.edit');
    Route::put('/ejercicios/{exercise}', [ExerciseController::class, 'update'])->name('ejercicios.update');
    Route::view('/evidencias', 'fitapp.admin.evidencias')->name('evidencias');
    Route::get('/logros', [AchievementController::class, 'index'])->name('logros');
    Route::get('/logros/crear', [AchievementController::class, 'create'])->name('logros.crear');
    Route::post('/logros', [AchievementController::class, 'store'])->name('logros.store');
    Route::get('/logros/{achievement}/editar', [AchievementController::class, 'edit'])->name('logros.edit');
    Route::put('/logros/{achievement}', [AchievementController::class, 'update'])->name('logros.update');
    Route::post('/logros/{achievement}/desbloquear', [AchievementController::class, 'unlock'])->name('logros.unlock');
    Route::get('/nutricion', [NutritionController::class, 'index'])->name('nutricion');
    Route::get('/nutricion/crear', [NutritionController::class, 'create'])->name('nutricion.crear');
    Route::post('/nutricion', [NutritionController::class, 'store'])->name('nutricion.store');
    Route::get('/nutricion/{nutrition}', [NutritionController::class, 'show'])->name('nutricion.show');
    Route::get('/nutricion/{nutrition}/editar', [NutritionController::class, 'edit'])->name('nutricion.edit');
    Route::put('/nutricion/{nutrition}', [NutritionController::class, 'update'])->name('nutricion.update');
    Route::view('/pagos', 'fitapp.admin.pagos')->name('pagos');
    Route::view('/configuracion', 'fitapp.admin.configuracion')->name('configuracion');
});
