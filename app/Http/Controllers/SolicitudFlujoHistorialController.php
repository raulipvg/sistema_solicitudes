<?php

namespace App\Http\Controllers;

use App\Models\HistorialSolicitud;
use App\Models\OrdenFlujo;
use App\Models\Flujo;
use App\Models\Compuesta;
use App\Models\Solicitud;
use App\Models\Storage;
use Google\Cloud\Storage\StorageClient;
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
                                            'estado_flujo.Id as EstadoId',
                                         'flujo.Nombre as FlujoNombre'
                                        )
                    ->where('orden_flujo.FlujoId','=',$request['flujoId'])
                    ->join('estado_flujo','estado_flujo.Id','=','orden_flujo.EstadoFlujoId')
                    ->join('flujo','flujo.Id','=','orden_flujo.FlujoId')
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
 
        
        $query = Compuesta::select('solicitud.CostoSolicitud',
                                    'movimiento.Nombre as MovimientoNombre',
                                    'flujo.Nombre as FlujoNombre' ,
                                        DB::raw('CONCAT("[", GROUP_CONCAT(JSON_OBJECT(
                                            "Nombre", atributo.Nombre, 
                                            "Simbolo", tipo_moneda.Simbolo,
                                            "CostoReal", compuesta.CostoReal,
                                            "Descripcion", compuesta.Descripcion,
                                            "Cantidad", compuesta.Cantidad,
                                            "Fecha1", DATE_FORMAT(compuesta.Fecha1, "%d/%m/%y"),
                                            "Fecha2", DATE_FORMAT(compuesta.Fecha2, "%d/%m/%y")                                         
                                        )), "]") as Compuesta')
                                        )
                                        ->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                        ->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
                                        ->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
                                        ->join('flujo','flujo.Id','=','movimiento.FlujoId')
                                        ->join('solicitud','solicitud.Id','=','compuesta.SolicitudId')
                                        ->leftJoin('tipo_moneda','tipo_moneda.Id','=','compuesta.TipoMonedaId')
                                        ->where('solicitud.Id',$request['solicitudId'])
                                        ->groupBy('solicitud.CostoSolicitud', 'movimiento.Nombre', 'flujo.Nombre')
                                        ->first();
                                        
       

        $url= Storage::select('Nombre','Url')
                        ->where('SolicitudId',$request['solicitudId'])
                        ->orderBy('Nombre','asc')
                        ->get();

        $archivos = [];
        if(count($url)> 0){
            // Crear una instancia del cliente de Google Cloud Storage
            $storage = new StorageClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE')
            ]);
            // Crear un arreglo para almacenar las URLs autenticadas           
            foreach ($url as $item) {
                // Generar una URL autenticada con una validez de 5 minutes
                $object = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'))->object($item->Url);
                $urlAutenticada = $object->signedUrl(new \DateTime('+2 minutes'));
                // Agregar la URL autenticada al arreglo
                $archivos[] = [
                    'Nombre' => $item->Nombre, 
                    'Url' => $urlAutenticada
                ];
            }
        }

        return response()->json([
            'success'=> true,
            'data' => [
                'ordenFlujos' => $ordenFlujo,
                'historial' => $historial,
                'query' => $query,
                'archivo'=> $archivos,
            ]
        ]);
    }
}
