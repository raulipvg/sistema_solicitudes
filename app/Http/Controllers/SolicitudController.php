<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Compuesta;
use App\Models\Flujo;
use App\Models\HistorialSolicitud;
use App\Models\Movimiento;
use App\Models\Persona;
use App\Models\Solicitud;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class SolicitudController extends Controller
{
    //
    public int $modulo =1;
    public function Index()
    {

        $user = auth()->user();
        // 12 Privilegios de Solicitudes
        $credenciales = [
                'verGrupos'=> $user->puedeVer(12),                
                'verTodas'=> $user->puedeRegistrar(12),
                'realizar'=> $user->puedeEditar(12),
                'aprobador'=> $user->puedeEliminar(12)
        ];
       
        if( $credenciales['realizar']){
            $movimientos = Movimiento::select('Id','Nombre')
                                    ->where('Enabled',1)
                                    ->orderBy('Nombre','desc')
                                    ->get();

            $personas = Persona::select('Id','Rut',
                                DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"))
                                ->where('Enabled',1)
                                ->orderBy('NombreCompleto','asc')
                                ->get();
            $personas = Persona::select('Id','Rut',
                                DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"))
                                ->where('Enabled',1)
                                ->orderBy('NombreCompleto','asc')
                                ->get();

            $centrocostos = CentroDeCosto::select('centro_de_costo.Id', DB::raw("CONCAT(empresa.Nombre, ' - ', centro_de_costo.Nombre) AS Nombre"))
                                ->join('empresa','empresa.Id','=','centro_de_costo.EmpresaId')
                                ->where('centro_de_costo.Enabled','=', 1)
                                ->orderBy('Nombre','asc')
                                ->get();
        }else{
            $movimientos= null;
            $personas= null;
            $centrocostos = null;
        }
        
        if( !($credenciales['verGrupos'] || $credenciales['verTodas']) ){ //Modo 1, solo ver sus propias solicitudes
            $solicitudes = Solicitud::getSolicitudesListar(1,"<",$user->Id,0);
        }
        else if( $credenciales['verGrupos'] && !$credenciales['verTodas']){ //Modo 2, ver sus solicitudes y todas aquellas que en que su grupo participe
            $flujosParticipaGrupo = Flujo::select('flujo.Id as FlujoId')
                                        ->join('orden_flujo', 'orden_flujo.FlujoId', '=', 'flujo.Id')
                                        ->whereIn('orden_flujo.GrupoId', $user->grupos->where('pivot.Enabled', 1)->pluck('Id')->toArray())
                                        ->get();
            $solicitudes= Solicitud::getSolicitudesListar(2,"<",$user->Id, $flujosParticipaGrupo);
        }else if($credenciales['verTodas']){ //Modo 3, ver todas las solicitudes
            $solicitudes = Solicitud::getSolicitudesListar(3,"<",0,0);
        }
        Log::info('Ingreso vista Solicitud');

        return view('solicitud.solicitud')->with([
            'movimientos'=> $movimientos,
            'personas' => $personas,
            'centrocostos'=> $centrocostos,
            'solicitudes'=> json_encode($solicitudes),
            'credenciales' => $credenciales

        ]);
    }

    public function VerMovimientoAtributo(Request $request){  
        try{
            $request = $request->input('data');
            $movimientos = Movimiento::select('Id','Nombre')
                                    ->where('Enabled',1)
                                    ->orderBy('Nombre','desc')
                                    ->get();
            return response()->json([
                'success' => true,
                'movimientos' => $movimientos
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function RealizarSolicitud(Request $request){
        try{
            $request = $request->input('data');
            $userId = auth()->user()->Id;
            $request['solicitud']['UsuarioSolicitanteId'] = $userId;
            $solicitud = new Solicitud();
            $solicitud->validate($request['solicitud']);
            $solicitud->fill($request['solicitud']);
            
            DB::beginTransaction();
            $solicitud->save();

            foreach($request['compuesta'] as $compuesta){
                $obj = new Compuesta();
                $obj->MovimientoAtributoId = $compuesta['MovimientoAtributoId'];
                $obj->SolicitudId = $solicitud->Id;
                $obj->CostoReal = $compuesta['CostoReal'];
                $obj->Caracteristica = $compuesta['Caracteristica'];

                $obj->validate([
                    'MovimientoAtributoId' => $obj->MovimientoAtributoId,
                    'CostoReal' => $obj->CostoReal,
                    'Caracteristica' => $obj->Caracteristica,
                    'SolicitudId' => $obj->SolicitudId,
                ]);
                $obj->save();
            }
            $movExiste= Movimiento::find($request['movimiento']);
            if (!$movExiste) {
                throw new Exception('Movimiento no encontrado');
            }
            $flujo = $movExiste->flujo;
            if(!$flujo){
                throw new Exception('Flujo no encontrado');
            } 
            // Filtra la colección para obtener el orden_flujo con nivel 0.
            $ordenFlujoNivel0 = $flujo->orden_flujos->firstWhere('Nivel', 0);
            if(!$ordenFlujoNivel0){
                throw new Exception('Orden Flujo Nivel 0 no encontrado');
            }
            $estadoFlujoId = $ordenFlujoNivel0->estado_flujo->Id;

            $historial = new HistorialSolicitud();
            $historial->EstadoFlujoId = $estadoFlujoId;
            $historial->EstadoEtapaFlujoId = 3; //Pendiente
            $historial->SolicitudId = $solicitud->Id;
            $historial->EstadoSolicitudId = 1; //INICIADO
            $historial->UsuarioId = $userId; 

            $historial->validate([
                'EstadoFlujoId' => $historial->EstadoFlujoId,
                'EstadoEtapaFlujoId' => $historial->EstadoEtapaFlujoId,
                'SolicitudId' => $historial->SolicitudId,
                'EstadoSolicitudId' => $historial->EstadoSolicitudId,
                'UsuarioId' => $historial->UsuarioId
            ]);

            $historial->save();
            DB::commit();
            Log::info('Solicitud #'.$solicitud->Id.' generada');

            $solicitud = Solicitud::getSolicitudesId($solicitud->Id);
                           
            return response()->json([
                'success' => true,
                'data'=> $solicitud,
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al generar solicitud', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function Aprobar(Request $request){
        try{
            $request = $request->input('data');
            //$solicitudId= $request['a'];
            $historialId = $request['b'];
            $flujoId = $request['c'];

            
            $historialEdit= HistorialSolicitud::find($historialId);
            if (!$historialEdit) { throw new Exception('Historial no encontrado');}
            $flujoExiste = Flujo::find($flujoId);
            if (!$flujoExiste) { throw new Exception('Flujo no encontrado');}

            DB::beginTransaction();
            
            $estadoFlujoId= $historialEdit->EstadoFlujoId;
            $ordenFlujo = $flujoExiste->orden_flujos;

            $ordenFlujoEstadoExiste = $ordenFlujo->firstWhere('EstadoFlujoId', $estadoFlujoId);
            if (!$ordenFlujoEstadoExiste){ throw new Exception('No existe el estado en el flujo');}

            $userId = auth()->user()->Id;
            // SI ES UNA ETAPA DEL FLUJO INICIAL O INTERMEDIA
            $flag=true;
            if($ordenFlujoEstadoExiste->Pivot < 2){
                $ordenFlujoNext= $ordenFlujo->firstWhere('Nivel', $ordenFlujoEstadoExiste->Nivel+1);

                $historialEdit->update([
                    'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA
                    'UsuarioId'=> $userId 
                ]);
                
                $historial = new HistorialSolicitud();
                $historial->EstadoFlujoId = $ordenFlujoNext->estado_flujo->Id;
                $historial->EstadoEtapaFlujoId =3; //Pendiente
                $historial->SolicitudId = $historialEdit->SolicitudId;
                $historial->EstadoSolicitudId = 2; //En Curso
 
                $historial->save();
                $flag=true;

                $mensaje = 'Solicitud #'.$historial->SolicitudId.' avanzó de etapa.';

            //SI ES UNA ETAPA FINAL DEL FLUJO
            }else{
                $historialEdit->update([
                    'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA,
                    'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                    'UsuarioId' => $userId 
                ]);
                $flag=false;
                $mensaje = 'Solicitud #'.$historialEdit->SolicitudId.' aprobada y terminada.';
            }

            DB::commit(); 
            Log::info($mensaje);
            return response()->json([
                'success' => true,
                'data' => [
                    'flag'=> $flag, //Pivot <2 o no
                    'historialId'=> ($flag)? $historial->Id : null,
                    'estadoSolicitudId'=>($flag)? $historial->EstadoSolicitudId : null,
                    'flujoNombre' => ( $flag)? $ordenFlujoNext->estado_flujo->Nombre : null,
                ]
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error en el avance de la solicitud #'.$historialEdit->SolicitudId,[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function Rechazar(Request $request){
        try{
            $request = $request->input('data');
            //$solicitudId= $request['a'];
            $historialId = $request['b'];
            $flujoId = $request['c'];

            
            $historialEdit= HistorialSolicitud::find($historialId);
            if (!$historialEdit) { throw new Exception('Historial no encontrado');}
            $flujoExiste = Flujo::find($flujoId);
            if (!$flujoExiste) { throw new Exception('Flujo no encontrado');}

            DB::beginTransaction();
            $estadoFlujoId= $historialEdit->EstadoFlujoId;
            $ordenFlujo = $flujoExiste->orden_flujos;

            $ordenFlujoEstadoExiste = $ordenFlujo->firstWhere('EstadoFlujoId', $estadoFlujoId);
            if (!$ordenFlujoEstadoExiste){ throw new Exception('No existe el estado en el flujo');}
            $userId = auth()->user()->Id;
            $historialEdit->update([
                    'EstadoEtapaFlujoId' => 2,  //ETAPA Rechazada,
                    'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                    'UsuarioId' => $userId 
                ]);
        
            DB::commit(); 
            Log::info('Solicitud #'.$historialEdit->SolicitudId.' rechazada y terminada.');
            return response()->json([
                'success' => true
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al rechazar solicitud #'.$historialEdit->SolicitudId,[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function VerTerminadas(){
        try{

            $solicitudes = Solicitud::getSolicitudes("=",0);

            Log::info('Ingreso vista solicitudes terminadas');
        return response()->json([
                'success' => true,
                'solicitudes' => $solicitudes
            ]);
        }catch(Exception $e){
            Log::error('Error al ver solicitudes terminadas', [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }

    }

    public function VerActivas(){
        try{
            $user = auth()->user();
            $credenciales = [
                'verGrupos'=> $user->puedeVer(12),                
                'verTodas'=> $user->puedeRegistrar(12),
                'realizar'=> $user->puedeEditar(12),
                'aprobador'=> $user->puedeEliminar(12)
            ];

            if( !($credenciales['verGrupos'] || $credenciales['verTodas']) ){ //Modo 1, solo ver sus propias solicitudes
                $solicitudes = Solicitud::getSolicitudes(1,"<",$user->Id,0);
            }
            if( $credenciales['verGrupos'] && !$credenciales['verTodas']){ //Modo 2, ver sus solicitudes y todas aquellas que en que su grupo participe
                $flujosParticipaGrupo = Flujo::select('flujo.Id as FlujoId')
                                            ->join('orden_flujo', 'orden_flujo.FlujoId', '=', 'flujo.Id')
                                            ->whereIn('orden_flujo.GrupoId', $user->grupos->where('pivot.Enabled', 1)->pluck('Id')->toArray())
                                            ->get();
                $solicitudes= Solicitud::getSolicitudes(2,"<",0, $flujosParticipaGrupo);
            }elseif($credenciales['verTodas']){ //Modo 3, ver todas las solicitudes
                $solicitudes = Solicitud::getSolicitudes(3,"<",0,0);
            }
            Log::info('Ingreso vista solicitudes activas');

            return response()->json([
                'success' => true,
                'solicitudes' => $solicitudes
            ]);

        }catch(Exception $e){
            Log::error('Error al ver solicitudes activas', [$e]);
            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()
            ]);
        }

    }

}

