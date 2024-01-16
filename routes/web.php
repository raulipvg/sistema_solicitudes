<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioGrupoController;
use App\Http\Controllers\EstadoFlujoController;
use App\Http\Controllers\AtributoController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\FlujoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovimientoAtributoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\EstadoFlujoSolicitudControllerTest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

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

Route::group(['prefix' => '/usuario', 'middleware' => 'auth'], function () { //LISTO
    Route::get('/', [UsuarioController::class, 'Index'])->name('Usuario');
    Route::post('/registrar', [UsuarioController::class, 'Guardar'])->name('GuardarUsuario');
    Route::post('/ver', [UsuarioController::class, 'VerId'])->name('VerUsuario');
    Route::post('/editar', [UsuarioController::class, 'Editar'])->name('EditarUsuario');
    Route::post('/cambiarestado', [UsuarioController::class, 'CambiarEstado'])->name('CambiarEstadoUsuario');
    Route::post('/vercc', [UsuarioController::class, 'VerCC'])->name('VerCC');
});


Route::group(['prefix' => '/usuariogrupo'], function () { //
    Route::post('/ver', [UsuarioGrupoController::class, 'Ver'])->name('VerUsuarioGrupo');
    Route::post('/vergrupos', [UsuarioGrupoController::class, 'VerGrupo'])->name('VerGrupoPorUsuario');
    Route::post('/registrar', [UsuarioGrupoController::class, 'Registrar'])->name('GuardarUsuarioGrupo');
    Route::post('/eliminar', [UsuarioGrupoController::class, 'Eliminar'])->name('DeleteUsuarioGrupo');

    //Route::get('/', [UserController::class, 'Index'])->name('Usuario');
    //Route::post('/registrar', [AccesoComunidadController::class, 'Guardar'])->name('RegistrarAcceso');
    
    //Route::post('/editar', [AccesoComunidadController::class, 'Editar'])->name('EditarAcceso');
    //Route::post('/comunidadsinacceso',[AccesoComunidadController::class, 'getComunidadSinAcceso'])->name('ComunidadSinAcceso');
});

Route::group(['prefix' => '/grupo'], function () {
    Route::get('/', [GrupoController::class, 'Index'])->name('Grupo');
    Route::get('/ver/{id}', [GrupoController::class, 'Ver'])->name('VerGrupo');
    Route::post('/registrar', [GrupoController::class, 'Guardar'])->name('GuardarGrupo');
    Route::post('/veredit', [GrupoController::class, 'VerEdit'])->name('VerGrupoEdit');
    Route::post('/editargrupoprivilegio', [GrupoController::class, 'EditarGrupoPrivilegio'])->name('EditarGrupoPrivilegio');
    Route::post('/cambiarestado', [GrupoController::class,'CambiarEstado'])->name('CambiarEstadoGrupo');
    //Route::post('/asignar',[AccesoComunidadController::class, 'AsignarGrupo'])->name('AsignarGrupo');
});


Route::group(['prefix' => '/estadoflujo'], function () {
    Route::get('/', [EstadoFlujoController::class, 'Index'])->name('EstadoFlujo');
    Route::post('/registrar', [EstadoFlujoController::class, 'Guardar'])->name('GuardarEstado');
    Route::post('/ver', [EstadoFlujoController::class, 'VerId'])->name('VerEstado');
    Route::post('/editar', [EstadoFlujoController::class, 'Editar'])->name('EditarEstado');
    Route::post('/editarEstado', [EstadoFlujoController::class, 'CambiarEstado'])->name('CambiarEstadoEstado');
});

Route::group(['prefix' => '/atributo'], function () {
    Route::get('/', [AtributoController::class, 'Index'])->name('Atributo');
    Route::post('/registrar', [AtributoController::class, 'Guardar'])->name('GuardarAtributo');
    Route::post('/ver', [AtributoController::class, 'VerId'])->name('VerAtributo');
    Route::post('/editar', [AtributoController::class, 'Editar'])->name('EditarAtributo');
    Route::post('/editarEstado', [AtributoController::class, 'CambiarEstado'])->name('CambiarEstadoAtributo');
});

Route::group(['prefix' => '/movimiento'], function () {
    Route::get('/', [MovimientoController::class, 'Index'])->name('Movimiento');
    Route::post('/registrar', [MovimientoController::class, 'Guardar'])->name('GuardarMovimiento');
    Route::post('/ver', [MovimientoController::class, 'VerId'])->name('VerMovimiento');
    Route::post('/editar', [MovimientoController::class, 'Editar'])->name('EditarMovimiento');
    Route::post('/editarEstado', [MovimientoController::class, 'CambiarEstado'])->name('CambiarEstadoMovimiento');
    Route::post('/flujosGrupos', [MovimientoController::class, 'VerGruposFlujos'])->name('VerGruposFlujosMovimiento');
});

Route::group(['prefix'=> '/area'], function () {
    Route::get('/', [AreaController::class,'Index'])->name('Area');
    Route::post('/registrar', [AreaController::class, 'Guardar'])->name('GuardarArea');
    Route::post('/ver', [AreaController::class, 'VerId'])->name('VerArea');
    Route::post('/editar', [AreaController::class, 'Editar'])->name('EditarArea');
    Route::post('/cambiarestado', [AreaController::class, 'CambiarEstado'])->name('CambiarEstadoArea');
    Route::post('/verflujos', [AreaController::class, 'VerFlujos'])->name('VerFlujos');
});

Route::group(['prefix'=> '/flujo'], function () {
    Route::get('/', [FlujoController::class,'Index'])->name('Flujo');
    Route::post('/eliminar', [FlujoController::class, 'Eliminar'])->name('EliminarFlujo');
    Route::post('/registrar', [FlujoController::class, 'Guardar'])->name('GuardarFlujo');
});

Route::group(['prefix'=> '/empresa'], function () {
    Route::get('/', [EmpresaController::class,'Index'])->name('Empresa');
    Route::post('/registrar', [EmpresaController::class, 'Guardar'])->name('GuardarEmpresa');
    Route::post('/ver', [EmpresaController::class, 'VerId'])->name('VerEmpresa');
    Route::post('/editar', [EmpresaController::class, 'Editar'])->name('EditarEmpresa');
    Route::post('/cambiarestado', [EmpresaController::class, 'CambiarEstado'])->name('CambiarEstadoEmpresa');
    Route::post('/vercentrocosto', [EmpresaController::class, 'VerCentroCosto'])->name('VerCentroCosto');
    Route::post('/Vercentrocostoempresa', [EmpresaController::class, 'VerCentroCostoxEmpresa'])->name('VerCentroCostoxEmpresa');
});

Route::group(['prefix'=> '/centrocosto'], function () {
    Route::post('/registrar', [CentroCostoController::class,'Guardar'])->name('GuardarCentroCosto');
    Route::post('/cambiarestado', [CentroCostoController::class, 'CambiarEstado'])->name('CambiarEstadoCentroCosto');
});

Route::group(['prefix'=> '/persona'], function () {
    Route::get('/', [PersonaController::class,'Index'])->name('Persona');
    Route::post('/registrar', [PersonaController::class, 'Guardar'])->name('GuardarPersona');
    Route::post('/ver', [PersonaController::class, 'VerId'])->name('VerPersona');
    Route::post('/editar', [PersonaController::class, 'Editar'])->name('EditarPersona');
    Route::post('/cambiarestado', [PersonaController::class, 'CambiarEstado'])->name('CambiarEstadoPersona');
    Route::post('/daracceso', [PersonaController::class, 'DarAcceso'])->name('DarAccesoPersona');

});

Route::group(['prefix'=> '/movimientoatributo'], function () {
    Route::get('/', [MovimientoAtributoController::class, 'Index'])->name('InicioMovimientoAtributo');
    Route::post('/registrar', [MovimientoAtributoController::class, 'Guardar'])->name('GuardarMovimientoAtributo');
    Route::post('/ver', [MovimientoAtributoController::class, 'Ver'])->name('VerMovimientoAtributo');
    Route::post('/verAtributos', [MovimientoAtributoController::class, 'AtributosFaltantes'])->name('VerAtributosFaltantes');
});

Route::group(['prefix'=> '/solicitud'], function () {
    Route::get('/', [SolicitudController::class,'Index'])->name('Solicitud');
    Route::post('/datosSolicitud', [EstadoFlujoSolicitudControllerTest::class,'GetData'])->name('DataTestSolicitud');
    Route::post('/historial', [EstadoFlujoSolicitudControllerTest::class,'getHistorial'])->name('getHistorial');
    Route::post('/RealizarSolicitud', [SolicitudController::class,'RealizarSolicitud'])->name('RealizarSolicitud');
    Route::post('/aprobar', [SolicitudController::class,'Aprobar'])->name('AprobarSolicitud');
    Route::post('/rechazar', [SolicitudController::class,'Rechazar'])->name('RechazarSolicitud');
    Route::get('/verterminadas', [SolicitudController::class,'VerTerminadas'])->name('VerTerminadas');
});

Route::group(['prefix' => '/error'], function () {
    Route::get('/404', function () {return view('error.error404');})->name('Error404');
    Route::get('/500', function () {return view('error.error500');})->name('Error500');
});


Route::get('/test', function () {
    try {
        DB::connection()->getPdo();
        return "Conexión a la base de datos exitosa.";
    } catch (\Exception $e) {
        return "Error al conectar a la base de datos: " . $e->getMessage();
    }
});

Route::group(['prefix'=>'/login'], function(){
    Route::get('/', [LoginController::class, 'Index'])->name('login');
    Route::post('/camanchaca', [LoginController::class, 'InicioNormal'])->name('login.normal');
    Route::get('/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);
    Route::get('/logout', [LoginController::class, 'CerrarSesion'])->name('CerrarSesion');
});
