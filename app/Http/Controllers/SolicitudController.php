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

use function Laravel\Prompts\select;

class SolicitudController extends Controller
{
    //
    public int $modulo =1;
    public function Index(){

        $movimientos = Movimiento::select('Id','Nombre')
                                ->where('Enabled',1)
                                ->orderBy('Nombre','desc')
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

        $solicitudes = Solicitud::select('solicitud.Id',DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"),
                                        'centro_de_costo.Nombre as CentroCosto','FechaDesde','FechaHasta',
                                        'solicitud.created_at as FechaCreado','historial_solicitud.EstadoSolicitudId',
                                        'estado_flujo.Nombre as EstadoFlujo', 'Movimiento.Nombre as Movimiento',
                                        'flujo.Nombre as NombreFlujo',
                                        'historial_solicitud.Id as HistorialId',
                                        'flujo.Id as FlujoIdd',
                                        DB::raw('GROUP_CONCAT(atributo.Nombre) as Atributos'),
                                        DB::raw('(
                                            SELECT CONCAT(persona_solicitante.Nombre, " ", persona_solicitante.Apellido)
                                            FROM usuario
                                            JOIN persona AS persona_solicitante ON persona_solicitante.UsuarioId = usuario.Id
                                            WHERE usuario.Id = solicitud.UsuarioSolicitanteId
                                        ) as UsuarioNombre')
                                        )
                                ->join('persona','persona.Id','=','solicitud.PersonaId')
                                ->join('centro_de_costo','centro_de_costo.Id','=','solicitud.CentroCostoId')
                                ->join('historial_solicitud', function ($join) {
                                    $join->on('historial_solicitud.SolicitudId', '=', 'solicitud.Id')
                                         ->where('historial_solicitud.created_at', '=', DB::raw('(
                                                            SELECT MAX(created_at) 
                                                            FROM historial_solicitud 
                                                            WHERE SolicitudId = solicitud.Id
                                                            )'));
                                })
                                ->join('estado_flujo','estado_flujo.Id','=','historial_solicitud.EstadoFlujoId')
                                ->where('historial_solicitud.EstadoSolicitudId','=', 1)
                                ->orWhere('historial_solicitud.EstadoSolicitudId','=', 2)
                                ->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')                                
                                ->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                ->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
                                ->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
                                ->join('flujo','flujo.Id','=','movimiento.FlujoId')
                                ->groupBy('solicitud.Id', 'NombreCompleto', 'CentroCosto', 'FechaDesde', 'FechaHasta', 'FechaCreado', 'EstadoSolicitudId', 
                                'EstadoFlujo', 'Movimiento', 'NombreFlujo', 'HistorialId','FlujoIdd','UsuarioSolicitanteId')
                                ->get();

        return view('solicitud.solicitud')->with([
            'movimientos'=> $movimientos,
            'personas' => $personas,
            'centrocostos'=> $centrocostos,
            'solicitudes'=> json_encode($solicitudes)

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
            //BEGIN::ARREGLAR 
            $request['UsuarioSolicitanteId'] = 1;
            //END::ARREGLAR
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
            //ARREGLAR USUARIO SEGUN SESION
            //$historial->UsuarioId = 1; 

            $historial->validate([
                'EstadoFlujoId' => $historial->EstadoFlujoId,
                'EstadoEtapaFlujoId' => $historial->EstadoEtapaFlujoId,
                'SolicitudId' => $historial->SolicitudId,
                'EstadoSolicitudId' => $historial->EstadoSolicitudId,
                'UsuarioId' => $historial->UsuarioId
            ]);

            $historial->save();
            DB::commit();
            return response()->json([
                'success' => true
            ],201);
        }catch(Exception $e){
            DB::rollBack();
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

            // SI ES UNA ETAPA DEL FLUJO INICIAL O INTERMEDIA
            $flag=true;
            if($ordenFlujoEstadoExiste->Pivot < 2){
                $ordenFlujoNext= $ordenFlujo->firstWhere('Nivel', $ordenFlujoEstadoExiste->Nivel+1);

                //BEGIN::ARREGLAR LO DEL USUARIO
                $historialEdit->update([
                    'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA
                    'UsuarioId'=> 1 //****ARREGLAR LO DE USUARIO*****
                ]);
                //END::ARREGLAR LO DEL USUARIO 
                
                $historial = new HistorialSolicitud();
                $historial->EstadoFlujoId = $ordenFlujoNext->estado_flujo->Id;
                $historial->EstadoEtapaFlujoId =3; //Pendiente
                $historial->SolicitudId = $historialEdit->SolicitudId;
                $historial->EstadoSolicitudId = 2; //En Curso
 
                $historial->save();
                $flag=true;

            //SI ES UNA ETAPA FINAL DEL FLUJO
            }else{
                $historialEdit->update([
                    'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA,
                    'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                    'UsuarioId' => 1 //****ARREGLAR LO DE USUARIO*****
                ]);
                $flag=false;
            }

            DB::commit(); 
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

            $historialEdit->update([
                    'EstadoEtapaFlujoId' => 2,  //ETAPA Rechazada,
                    'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                    'UsuarioId' => 1 //****ARREGLAR LO DE USUARIO*****
                ]);
        
            DB::commit(); 
            return response()->json([
                'success' => true
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function VerTerminadas(){
        try{
        $solicitudes = Solicitud::select('solicitud.Id',DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"),
                                        'centro_de_costo.Nombre as CentroCosto','FechaDesde','FechaHasta',
                                        'solicitud.created_at as FechaCreado','historial_solicitud.EstadoSolicitudId',
                                        'estado_flujo.Nombre as EstadoFlujo', 'Movimiento.Nombre as Movimiento',
                                        'flujo.Nombre as NombreFlujo',
                                        'historial_solicitud.Id as HistorialId',
                                        'flujo.Id as FlujoIdd',
                                        DB::raw('GROUP_CONCAT(atributo.Nombre) as Atributos'),
                                        DB::raw('(
                                            SELECT CONCAT(persona_solicitante.Nombre, " ", persona_solicitante.Apellido)
                                            FROM usuario
                                            JOIN persona AS persona_solicitante ON persona_solicitante.UsuarioId = usuario.Id
                                            WHERE usuario.Id = solicitud.UsuarioSolicitanteId
                                        ) as UsuarioNombre')
                                        )
                                ->join('persona','persona.Id','=','solicitud.PersonaId')
                                ->join('centro_de_costo','centro_de_costo.Id','=','solicitud.CentroCostoId')
                                ->join('historial_solicitud', function ($join) {
                                    $join->on('historial_solicitud.SolicitudId', '=', 'solicitud.Id')
                                        ->where('historial_solicitud.created_at', '=', DB::raw('(
                                                            SELECT MAX(created_at) 
                                                            FROM historial_solicitud 
                                                            WHERE SolicitudId = solicitud.Id
                                                            )'));
                                })
                                ->join('estado_flujo','estado_flujo.Id','=','historial_solicitud.EstadoFlujoId')
                                ->where('historial_solicitud.EstadoSolicitudId','=', 3)
                                ->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')                                
                                ->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                ->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
                                ->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
                                ->join('flujo','flujo.Id','=','movimiento.FlujoId')
                                ->groupBy('solicitud.Id', 'NombreCompleto', 'CentroCosto', 'FechaDesde', 'FechaHasta', 'FechaCreado', 'EstadoSolicitudId', 
                                'EstadoFlujo', 'Movimiento', 'NombreFlujo', 'HistorialId','FlujoIdd','UsuarioSolicitanteId')
                                ->get();


        return response()->json([
                'success' => true,
                'solicitudes' => $solicitudes
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }

    }

    public function VerActivas(){
        try{
            $solicitudes = Solicitud::select('solicitud.Id',DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"),
                                        'centro_de_costo.Nombre as CentroCosto','FechaDesde','FechaHasta',
                                        'solicitud.created_at as FechaCreado','historial_solicitud.EstadoSolicitudId',
                                        'estado_flujo.Nombre as EstadoFlujo', 'Movimiento.Nombre as Movimiento',
                                        'flujo.Nombre as NombreFlujo',
                                        'historial_solicitud.Id as HistorialId',
                                        'flujo.Id as FlujoIdd',
                                        DB::raw('GROUP_CONCAT(atributo.Nombre) as Atributos'),
                                        DB::raw('(
                                            SELECT CONCAT(persona_solicitante.Nombre, " ", persona_solicitante.Apellido)
                                            FROM usuario
                                            JOIN persona AS persona_solicitante ON persona_solicitante.UsuarioId = usuario.Id
                                            WHERE usuario.Id = solicitud.UsuarioSolicitanteId
                                        ) as UsuarioNombre')
                                        )
                                ->join('persona','persona.Id','=','solicitud.PersonaId')
                                ->join('centro_de_costo','centro_de_costo.Id','=','solicitud.CentroCostoId')
                                ->join('historial_solicitud', function ($join) {
                                    $join->on('historial_solicitud.SolicitudId', '=', 'solicitud.Id')
                                         ->where('historial_solicitud.created_at', '=', DB::raw('(
                                                            SELECT MAX(created_at) 
                                                            FROM historial_solicitud 
                                                            WHERE SolicitudId = solicitud.Id
                                                            )'));
                                })
                                ->join('estado_flujo','estado_flujo.Id','=','historial_solicitud.EstadoFlujoId')
                                ->where('historial_solicitud.EstadoSolicitudId','=', 1)
                                ->orWhere('historial_solicitud.EstadoSolicitudId','=', 2)
                                ->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')                                
                                ->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                ->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
                                ->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
                                ->join('flujo','flujo.Id','=','movimiento.FlujoId')
                                ->groupBy('solicitud.Id', 'NombreCompleto', 'CentroCosto', 'FechaDesde', 'FechaHasta', 'FechaCreado', 'EstadoSolicitudId', 
                                'EstadoFlujo', 'Movimiento', 'NombreFlujo', 'HistorialId','FlujoIdd','UsuarioSolicitanteId')
                                ->get();
            return response()->json([
                'success' => true,
                'solicitudes' => $solicitudes
            ]);

        }catch(Exception $e){
            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()
            ]);
        }

    }
}

