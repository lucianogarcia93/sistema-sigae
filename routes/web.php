<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\CursoMateriaController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\JustificacionController;
use App\Http\Controllers\AsistenciaAlumnoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CalificacionController;

/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta pública para confirmar inscripción desde el correo
Route::get('alumnos/confirmar/{token}', [AlumnoController::class, 'confirmar'])
    ->name('alumnos.confirmar');

/*
|--------------------------------------------------------------------------
| INSCRIPCIÓN PÚBLICA (SIN LOGIN)
|--------------------------------------------------------------------------
*/

Route::prefix('academica')->name('academica.')->group(function () {
    Route::get('inscripcion/curso/{curso}', [CursoController::class, 'formInscripcion'])
        ->name('cursos.inscripcion.form');
    Route::post('inscripcion/curso/{curso}', [CursoController::class, 'storeInscripcion'])
        ->name('cursos.inscripcion.store');
});

/*
|--------------------------------------------------------------------------
| 🔥 VER ESTADO SOLICITUD (PÚBLICO)
|--------------------------------------------------------------------------
*/

Route::get('/estado-solicitud/{token}', [SolicitudController::class, 'verEstado'])
    ->name('solicitud.estado');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [AlumnoController::class, 'dashboard'])
        ->name('dashboard');

    // CAMBIAR CONTRASEÑA ALUMNO
    Route::get('/alumno/password', function () {
        return view('usuario_alumno.password.clave');
    })->name('alumno.password');
    Route::post('/alumno/password', [AuthController::class, 'updatePassword'])->name('alumno.password.update');

    // RESUMEN Y DATOS DEL ALUMNO
    Route::get('/resumen-general', [AlumnoController::class, 'resumen'])->name('alumno.resumen');
    Route::get('/mis-datos', [AlumnoController::class, 'verDatosPersonales'])->name('alumno.datos');

    // ASISTENCIAS Y FERIADOS
    Route::get('/mis-asistencias', [AsistenciaAlumnoController::class, 'historialAlumno'])->name('alumno.asistencias.historial');
    Route::get('/mis-feriados', [FeriadoController::class, 'verFeriadosAlumno'])->name('alumno.feriados');

    // JUSTIFICACIONES
    Route::get('/alumno/justificacion/motivo', [JustificacionController::class, 'create'])->name('alumno.justificacion.motivo');
    Route::post('/alumno/justificacion/guardar', [JustificacionController::class, 'store'])->name('alumno.justificacion.store');
    Route::get('/alumno/justificaciones', [JustificacionController::class, 'index'])->name('alumno.justificacion.index');

    // 🔔 NOTIFICACIONES (NUEVO)
    Route::get('/alumno/notificaciones', [FeriadoController::class, 'notificacionesAlumno'])
        ->name('alumno.notificaciones');

    // 📊 MIS NOTAS (NUEVO)
    Route::get('/alumno/notas', [CalificacionController::class, 'misNotas'])->name('alumno.notas');

    /*
    |--------------------------------------------------------------------------
    | MÓDULO ACADÉMICA
    |--------------------------------------------------------------------------
    */
    Route::prefix('academica')->name('academica.')->group(function () {

        Route::resource('niveles', NivelController::class)->parameters(['niveles' => 'nivel']);
        Route::resource('cursos', CursoController::class);
        Route::get('cursos/{curso}/qr', [CursoController::class, 'qr'])->name('cursos.qr');

        Route::resource('alumnos', AlumnoController::class);
        Route::patch('alumnos/{alumno}/aprobar', [AlumnoController::class, 'aprobar'])->name('alumnos.aprobar');
        Route::patch('alumnos/{alumno}/rechazar', [AlumnoController::class, 'rechazar'])->name('alumnos.rechazar');

        Route::resource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);

        // NUEVO MÓDULO MATERIAS
        Route::resource('materias', MateriaController::class)
            ->parameters(['materias' => 'materia']);

        Route::get('cursos/{curso}/materias', [CursoMateriaController::class, 'index'])
            ->name('cursos.materias');

        Route::put('cursos/{curso}/materias', [CursoMateriaController::class, 'update'])
            ->name('cursos.materias.update');

        // RUTAS DE SOLICITUDES (ADMIN)
        Route::get('solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::post('solicitudes/{id}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
        Route::post('solicitudes/{id}/rechazar', [SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO CALENDARIO
    |--------------------------------------------------------------------------
    */
    Route::prefix('calendario')->name('calendario.')->group(function () {
        Route::resource('feriados', FeriadoController::class)->parameters(['feriados' => 'feriado']);
        Route::get('/justificaciones', [JustificacionController::class, 'indexAdmin'])->name('justificaciones.index');
        Route::put('/justificaciones/{id}', [JustificacionController::class, 'update'])->name('justificaciones.update');
        
        Route::resource('calificaciones', CalificacionController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | ASISTENCIA ALUMNO
    |--------------------------------------------------------------------------
    */
    Route::prefix('asistencia/alumno')->name('asistencia.asistencia_alumno.')->group(function () {
        Route::get('/', [AsistenciaAlumnoController::class, 'index'])->name('index');
        Route::get('/create', [AsistenciaAlumnoController::class, 'create'])->name('create');
        Route::post('/', [AsistenciaAlumnoController::class, 'store'])->name('store');
        Route::get('/edit', [AsistenciaAlumnoController::class, 'edit'])->name('edit');
        Route::put('/update', [AsistenciaAlumnoController::class, 'update'])->name('update');
        
        Route::get('cargar-planilla', [AsistenciaAlumnoController::class, 'cargarPlanilla'])
            ->name('cargarPlanilla');
    });

    /*
    |--------------------------------------------------------------------------
    | REPORTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/generales', [ReporteController::class, 'generales'])->name('generales');

        Route::get('/estadisticas', [ReporteController::class, 'estadistica'])
            ->name('alumnos.estadistica');

        Route::get('/estadisticas/pdf', [ReporteController::class, 'estadisticaPdf'])
            ->name('alumnos.estadistica.pdf');

        Route::get('/excel', [ReporteController::class, 'index'])->name('excel');

        Route::get('/export', [ReporteController::class, 'export'])->name('export');
    });

});