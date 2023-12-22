<?php

use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioGrupoController;
use App\Http\Controllers\EstadoSolicitudController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/'], function () {
    Route::get('/', [HomeController::class, 'Index'])->name('Home');
});

Route::group(['prefix' => '/usuario'], function () {
    Route::get('/', [UsuarioController::class, 'Index'])->name('Usuario');
    Route::post('/registrar', [UsuarioController::class, 'Guardar'])->name('GuardarUsuario');
    Route::post('/ver', [UsuarioController::class, 'VerId'])->name('VerUsuario');
    Route::post('/editar', [UsuarioController::class, 'Editar'])->name('EditarUsuario');
    Route::post('/cambiarestado', [UsuarioController::class, 'CambiarEstado'])->name('CambiarEstadoUsuario');
});


Route::group(['prefix' => '/usuariogrupo'], function () {
    Route::post('/ver', [UsuarioGrupoController::class, 'Ver'])->name('VerUsuarioGrupo');
    Route::post('/vergrupos', [UsuarioGrupoController::class, 'VerGrupo'])->name('VerGrupos');
    Route::post('/registrar', [UsuarioGrupoController::class, 'Registrar'])->name('GuardarUsuarioGrupo');
    Route::post('/eliminar', [UsuarioGrupoController::class, 'Eliminar'])->name('DeleteUsuarioGrupo');

    //Route::get('/', [UserController::class, 'Index'])->name('Usuario');
    //Route::post('/registrar', [AccesoComunidadController::class, 'Guardar'])->name('RegistrarAcceso');
    
    //Route::post('/editar', [AccesoComunidadController::class, 'Editar'])->name('EditarAcceso');
    //Route::post('/comunidadsinacceso',[AccesoComunidadController::class, 'getComunidadSinAcceso'])->name('ComunidadSinAcceso');
});

Route::group(['prefix' => '/grupo'], function () {
    Route::get('/', [GrupoController::class, 'Index'])->name('Grupo');
    //Route::post('/registrar', [AccesoComunidadController::class, 'Guardar'])->name('RegistrarAcceso');
    //Route::post('/ver', [UsuarioGrupoController::class, 'Ver'])->name('VerAcceso');
    //Route::post('/editar', [AccesoComunidadController::class, 'Editar'])->name('EditarAcceso');
    //Route::post('/asignar',[AccesoComunidadController::class, 'AsignarGrupo'])->name('AsignarGrupo');
});


Route::group(['prefix' => '/estadosolicitud'], function () {
    Route::get('/', [EstadoSolicitudController::class, 'Index'])->name('EstadoSolicitud');
    Route::post('/registrar', [EstadoSolicitudController::class, 'Guardar'])->name('GuardarEstado');
    Route::post('/ver', [EstadoSolicitudController::class, 'VerId'])->name('VerEstado');
    Route::post('/editar', [EstadoSolicitudController::class, 'Editar'])->name('EditarEstado');
    Route::post('/editarEstado', [EstadoSolicitudController::class, 'CambiarEstado'])->name('CambiarEstadoEstado');
});

Route::get('/test', function () {
    try {
        DB::connection()->getPdo();
        return "Conexión a la base de datos exitosa.";
    } catch (\Exception $e) {
        return "Error al conectar a la base de datos: " . $e->getMessage();
    }
});