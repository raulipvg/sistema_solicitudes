<?php

namespace App\Http\Controllers;

use App\Models\HistorialSolicitud;
use App\Models\OrdenFlujo;
use App\Models\Flujo;
use App\Models\Compuesta;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SolicitudFlujoHistorialController extends Controller
{
    public function GetFlujo(Request $request){
        $request = $request->input('data');

        $flujo = OrdenFlujo::select('orden_flujo.Nivel',
                                    'estado_flujo.Nombre',
                                    'estado_flujo.Id')
                            ->where('orden_flujo.FlujoId','=',$request['flujoId'])
                            ->join('estado_flujo','estado_flujo.Id','=','orden_flujo.EstadoFlujoId')
                            ->get();
        $historial = HistorialSolicitud::select(
                                            'historial_solicitud.EstadoFlujoId',
                                            'estado_etapa.Id as estadoEtapa',
                                            'estado_etapa.Nombre as estadoEtapaNombre',
                                            DB::raw('CONCAT(persona.Nombre, " ", persona.Apellido) as Usuario'),
                                        )
                                        ->where('historial_solicitud.SolicitudId', '=', $request['solicitudId'])
                                        ->leftJoin('persona', 'persona.UsuarioId', '=', 'historial_solicitud.UsuarioId')
                                        ->join('estado_etapa', 'estado_etapa.Id', '=', 'historial_solicitud.EstadoEtapaFlujoId')
                                        ->get();

        $flujoNombre = Flujo::select('Nombre')->where('Id',$request['flujoId'])->first()->Nombre;
        return response()->json([
            'success' => true,
            'data' => [
                'historial' => $historial,
                'ordenFlujos' => $flujo,
                'nombreFlujo' => $flujoNombre
            ]
        ]);
    }

    public function getHistorial(Request $request){
        $request = $request->input('data');

        $ordenFlujo = OrdenFlujo::select('orden_flujo.Nivel', 
                                            'estado_flujo.Nombre as EstadoNombre',
                                            'estado_flujo.Id as EstadoId'
                                        )
                    ->where('orden_flujo.FlujoId','=',$request['flujoId'])
                    ->join('estado_flujo','estado_flujo.Id','=','orden_flujo.EstadoFlujoId')
                    ->get();
        

        $historial = HistorialSolicitud::select('historial_solicitud.created_at as creacion', 
                                                'historial_solicitud.updated_at as actualizacion',
                                                'historial_solicitud.EstadoFlujoId as estadoFlujoId',
                                                'historial_solicitud.EstadoEtapaFlujoId',
                                                DB::raw('CONCAT(persona.Nombre, " ", persona.Apellido) as Usuario'),
                                                'historial_solicitud.EstadoSolicitudId')
                                        ->leftJoin('persona','persona.UsuarioId','=','historial_solicitud.UsuarioId')
                                        ->where('historial_solicitud.SolicitudId','=',$request['solicitudId'])
                                        ->get();
        $flujoNombre = Flujo::select('Nombre')->where('Id',$request['flujoId'])->first()->Nombre;  
        
        $costoPorAtributo = Compuesta::select('AtributoId as Atributo',
                                            'atributo.Nombre as Nombre',
                                            'atributo.ValorReferencia',
                                            'compuesta.CostoReal',
                                        )
                                        ->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                        ->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
                                        ->where('compuesta.SolicitudId',$request['solicitudId'])
                                        ->get();
        $costoSolicitud = Solicitud::select('CostoSolicitud')
                                        ->where('Id',$request['solicitudId'])
                                        ->first();

        return response()->json([
            'success'=> true,
            'data' => [
                'ordenFlujos' => $ordenFlujo,
                'historial' => $historial,
                'flujoNombre' => $flujoNombre,
                'costoPorAtributo' => $costoPorAtributo,
                'costoSolicitud' => $costoSolicitud->CostoSolicitud,
            ]
        ]);
    }
}
