<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('configuraciones.index');
});



/**** Configuraciones ****/
Route::get('configuraciones', [App\Http\Controllers\admin\ConfiguracionesController::class, 'index'])->name('configuraciones.index');
Route::post('configuraciones/store/ciclo', [App\Http\Controllers\admin\ConfiguracionesController::class, 'storeCiclo'])->name('configuraciones.store.ciclo');
Route::get('configuraciones/delete/ciclo', [App\Http\Controllers\admin\ConfiguracionesController::class, 'deleteCiclo'])->name('configuraciones.delete.ciclo');
Route::post('configuraciones/store/grado_grupo', [App\Http\Controllers\admin\ConfiguracionesController::class, 'storegrado_grupo'])->name('configuraciones.store.grado_grupo');
Route::get('configuraciones/delete/grado_grupo', [App\Http\Controllers\admin\ConfiguracionesController::class, 'deletegrado_grupo'])->name('configuraciones.delete.grado_grupo');



/**** Alumnos ****/
Route::get('alumnos', [App\Http\Controllers\admin\AlumnosController::class, 'index'])->name('alumnos.index');
Route::post('alumnos/store', [App\Http\Controllers\admin\AlumnosController::class, 'store'])->name('alumnos.store');
Route::get('alumnos/delete', [App\Http\Controllers\admin\AlumnosController::class, 'delete'])->name('alumnos.delete');

/**** Faltas y Retardos ****/
Route::get('faltas_retardos', [App\Http\Controllers\admin\FaltasRetardosController::class, 'index'])->name('faltas_retardos.index');
Route::get('faltas_retardos/registrar', [App\Http\Controllers\admin\FaltasRetardosController::class, 'registrar'])->name('faltas_retardos.registrar');
Route::get('faltas_retardos/cargarRegistros', [App\Http\Controllers\admin\FaltasRetardosController::class, 'cargarRegistros'])->name('faltas_retardos.cargarRegistros');






// Route::get('reportes_sanciones', [App\Http\Controllers\HomeController::class, 'index'])->name('reportes_sanciones.index');


// Route::get('calificaciones', [App\Http\Controllers\HomeController::class, 'index'])->name('calificaciones.index');


// Route::get('consultas', [App\Http\Controllers\HomeController::class, 'index'])->name('consultas.index');

// Route::get('admin', [App\Http\Controllers\Admin\SeeController::class, 'index'])->name('admin.index');
