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
    return view('welcome');
});



Route::get('alumnos', [App\Http\Controllers\admin\AlumnosController::class, 'index'])->name('alumnos.index');


// Route::get('reportes_sanciones', [App\Http\Controllers\HomeController::class, 'index'])->name('reportes_sanciones.index');


// Route::get('calificaciones', [App\Http\Controllers\HomeController::class, 'index'])->name('calificaciones.index');


// Route::get('consultas', [App\Http\Controllers\HomeController::class, 'index'])->name('consultas.index');

// Route::get('admin', [App\Http\Controllers\Admin\SeeController::class, 'index'])->name('admin.index');
