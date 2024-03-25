<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\ConsolidadoMe;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Solicitud;
use App\Models\TipoCambio;
use App\Models\Compuesta;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsolidadoController extends Controller
{
    public function Index (Request $request){
        $titulo= "Consolidado Mensual de solicitudes";
        //$usuarios = Usuario::all();
        //BEGIN::PRIVILEGIOS
        $user = auth()->user();

        $credenciales = [
            'Ver'=> $user->puedeVer(13),                
            'VerCC'=> $user->puedeRegistrar(13),
            'VerMov'=> $user->puedeEditar(13),
            'CerrarMes'=> $user->puedeEliminar(13)
        ];

        $accesoLayout= $user->todoPuedeVer();
        $mostrarBoton = false;


        $movimientos = Movimiento::select('Id','Nombre','Enabled')->get();
        $empresas = Empresa::select('Id','Nombre','Enabled')->get();
        $centrocostos = CentroDeCosto::select('Id','Nombre','Enabled')->get();
        $consolidados = ConsolidadoMe::select('Id',
                                                DB::raw('DATE_FORMAT(created_at, "%m - %Y") AS Nombre')
                                            )
                                            //->where('EstadoConsolidadoId','=', 0) //Consolidado Cerrado
                                            ->orderBy('Id','desc')
                                            ->get(); 
        
        $ultimoConsolidado = ConsolidadoMe::select('Id','created_at','EstadoConsolidadoId')
                                            ->orderBy('Id','desc')
                                            ->first();

        $fechaConsolidado = Carbon::create($ultimoConsolidado['created_at']);
        $mesNombre = $fechaConsolidado->locale('es')->monthName;

        //Si la fecha actual es después de 7 días antes de fin de mes, y se encuentra el consoliado abierto. gt() verifica "mayor qué"
        if(Carbon::now()->gt($fechaConsolidado->endOfMonth()->subDays(7)) && $ultimoConsolidado->EstadoConsolidadoId == 1) {
            $mostrarBoton = true;
        }

        return view('consolidado.consolidado')->with([
            'titulo' => $titulo,
            'movimientos' => $movimientos,
            'empresas'=> $empresas,
            'centrocostos'=> $centrocostos,
            'consolidados'=> $consolidados,
            'crendeciales' => $credenciales,
            'accesoLayout' => $accesoLayout,
            'mostrarBoton' => $mostrarBoton,
            'mesNombre'=> $mesNombre
        ]);
    }

    public function Indexs6 (Request $request){
        $titulo= "Consolidado Mensual de solicitudes";
        //$usuarios = Usuario::all();

        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        $accesoLayout= $user->todoPuedeVer();

        $movimientos = Movimiento::select('Id','Nombre','Enabled')->get();
        $empresas = Empresa::select('Id','Nombre','Enabled')->get();

        $centrocostos = CentroDeCosto::select('Id','Nombre','Enabled')->get(); 

        return view('consolidado.consolidado_s6')->with([
            'accesoLayout'=>$accesoLayout,
            'titulo' => $titulo,
            'movimientos' => $movimientos,
            'empresas'=> $empresas,
            'centrocostos'=> $centrocostos,
        ]);
    }

    public function VerConsolidados(Request $request){

        $request = $request->input('data');
        $empresaId = isset($request['Empresa'])?$request['Empresa']:null;
        $ccId = isset($request['CC'])?$request['CC']:null;
        $movimientoId = isset($request['Movimiento'])?$request['Movimiento']:null;
        $consolidadoId = $request['Consolidado'];

        try{
            //Busca el consolidado 
            $consolidado = ConsolidadoMe::select('consolidado_mes.Id','consolidado_mes.EstadoConsolidadoId', 
                                        DB::raw("DATE_FORMAT(tipo_cambio.updated_at, '%d-%m-%Y') AS updated_at"))
                                        ->where('consolidado_mes.Id','=',$consolidadoId)
                                        ->leftJoin('tipo_cambio','tipo_cambio.ConsolidadoId','=','consolidado_mes.Id')
                                        ->first();

            if(!$consolidado){throw new Exception('Consolidado no encontrado');}
            $flag=true;
            //SI EL ESTADO CONSOLIDADO ESTA ABIERTO  LLAMO A LA API DE INDICADORES
            if($consolidado->EstadoConsolidadoId == 1){
                $flag = $this->Calcular($consolidado);
            }
            if(!$flag){throw new Exception('Error Indicadores API');}

                $tipoCambio = TipoCambio::select('ToCLP','TipoMonedaId','Simbolo','Nombre')
                                        ->join('tipo_moneda','tipo_moneda.Id','=', 'tipo_cambio.TipoMonedaId')       
                                        ->where('ConsolidadoId', $consolidadoId)
                                        ->get();
                                
                $querySolicitud = Solicitud::select('empresa.Id as EmpresaId', 'empresa.Nombre as EmpresaNombre',
                                                        'centro_de_costo.Id as CcId', 
                                                        'centro_de_costo.Nombre as CcNombre', 
                                                        'atributo.Nombre as AtributoNombre',
                                                        'atributo.Id as AtributoId',
                                                        'consolidado_mes.Id as ConsolidadoId',
                                                        DB::raw('CONCAT("[", GROUP_CONCAT(JSON_OBJECT("CostoReal", compuesta.CostoReal, "TipoMonedaId", compuesta.TipoMonedaId)), "]") as CostoMoneda'),
                                                        DB::raw('COUNT(*) as Cantidad')
                                                        )
                                                ->join('consolidado_mes', 'consolidado_mes.Id', '=', 'solicitud.ConsolidadoMesId')
                                                ->join('centro_de_costo', 'centro_de_costo.Id', '=', 'solicitud.CentroCostoId')
                                                ->join('empresa', 'empresa.Id', '=', 'centro_de_costo.EmpresaId')
                                                ->join('historial_solicitud', 'historial_solicitud.SolicitudId','=','solicitud.Id')
                                                ->join('compuesta', 'compuesta.SolicitudId','=','solicitud.Id')
                                                ->join('movimiento_atributo', 'movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                                ->join('atributo', 'atributo.Id','=','movimiento_atributo.AtributoId')
                                                ->where('historial_solicitud.EstadoEtapaFlujoId','=', 1)
                                                ->where('historial_solicitud.EstadoSolicitudId','=', 3)
                                                ->where('solicitud.ConsolidadoMesId', $consolidadoId)
                                                //->where('empresa.Id', $empresaId)
                                                ->groupBy('empresa.Id', 'empresa.Nombre','centro_de_costo.Id','centro_de_costo.Nombre','atributo.Nombre', 'atributo.Id','consolidado_mes.Id')
                                                ->orderBy('centro_de_costo.Nombre','asc');

                    if($empresaId != null && $ccId ==null && $movimientoId ==null) {
                        $querySolicitud =$querySolicitud->where('empresa.Id', $empresaId)->get();                          
                    }else if ($ccId != null) {
                        if($movimientoId == null){
                            $querySolicitud = $querySolicitud->where('solicitud.CentroCostoId', '=', $ccId)->get();
                        }else{
                            $querySolicitud = $querySolicitud
                                                ->where('solicitud.CentroCostoId', '=', $ccId)
                                                ->where('movimiento_atributo.MovimientoId','=', $movimientoId)->get();
                        }
                    }else if($movimientoId !=null){
                        if( $empresaId !=null){
                            $querySolicitud = $querySolicitud
                                                    ->where('empresa.Id', $empresaId)
                                                    ->where('movimiento_atributo.MovimientoId', '=',$movimientoId)->get();
                        }else{
                            $querySolicitud = $querySolicitud->where('movimiento_atributo.MovimientoId', '=',$movimientoId)->get();
                        }
                    }else{
                        $querySolicitud = null;
                    }
            return response()->json([
                'success' => true,
                'query' => $querySolicitud,
                'tipoCambio'=> $tipoCambio,
                'consolidado'=> $consolidado,
                ]);
        }
        catch(Exception $e){
            Log::error('Error Ver Consolidado ',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'mensaje' =>$e->getMessage()
            ]);
        }

    }
    /*
    public function VerConsolidadoEmpresa(Request $request){
        $request = $request->input('data');
        $empresa = $request['empresa'];
        $cc = $request['cc'];
        $movimiento = $request['movimiento'];
        $ultimoConsolidado = 1;
        if($empresa > 0 && $cc<0 && $movimiento<0){
            $movimientosEmpresa = CentroDeCosto::select('movimiento.Id', 'movimiento.Nombre as Nombre')
                                ->join('solicitud', 'centro_de_costo.Id', '=', 'solicitud.CentroCostoId')
                                ->join('historial_solicitud', 'solicitud.Id', '=', 'historial_solicitud.SolicitudId')
                                ->join('compuesta', 'solicitud.Id', '=', 'compuesta.SolicitudId')
                                ->join('movimiento_atributo', 'compuesta.MovimientoAtributoId', '=', 'movimiento_atributo.Id')
                                ->join('movimiento', 'movimiento_atributo.MovimientoId', '=', 'movimiento.Id')
                                ->where('centro_de_costo.EmpresaId', $empresa)
                                ->where('historial_solicitud.EstadoSolicitudId', 3)
                                ->where('solicitud.ConsolidadoMesId',1)
                                ->groupBy('movimiento.Id', 'movimiento.Nombre')
                                ->get();
            $consolidado = CentroDeCosto::select('centro_de_costo.Nombre as NombreCentroCosto', 'movimiento.Nombre as NombreMovimiento', 'atributo.Nombre as NombreAtributo', DB::raw('COUNT(*) as CantidadAtributos'), DB::raw('SUM(compuesta.CostoReal) as SumaCostoReal'))
            ->join('solicitud', 'centro_de_costo.Id', '=', 'solicitud.CentroCostoId')
            ->join('compuesta', 'solicitud.Id', '=', 'compuesta.SolicitudId')
            ->join('movimiento_atributo', 'compuesta.MovimientoAtributoId', '=', 'movimiento_atributo.Id')
            ->join('atributo', 'movimiento_atributo.AtributoId', '=', 'atributo.Id')
            ->join('movimiento', 'movimiento_atributo.MovimientoId', '=', 'movimiento.Id')
            ->join('historial_solicitud', 'solicitud.Id', '=', 'historial_solicitud.SolicitudId')
            ->where('centro_de_costo.EmpresaId', $empresa)
            ->where('solicitud.ConsolidadoMesId', $ultimoConsolidado)
            ->where('historial_solicitud.EstadoSolicitudId', 3)
            ->groupBy('centro_de_costo.Nombre', 'movimiento.Nombre', 'atributo.Nombre')
            ->get();
        }
        return response()->json([
                        'success' => true,
                        'movimientosEmpresa' => $movimientosEmpresa,
                        'consolidado' => $consolidado
                        ]);
    } 
    */
    public function VerDetallesAsociados(Request $request){
        //DETALLES ASOCIADOS
        $request = $request->input('data');
        try{
            
            $ccId= $request['a']; 
            $atributo = $request['b']; 
            $consolidadoId = $request['c'];
            $movId = $request['d'];

            $querySolicitud = Solicitud::select( 'solicitud.Id as SolicitudId', 
                                                'movimiento.Nombre as Movimiento',
                                                'compuesta.Descripcion as Detalle',
                                                'compuesta.CostoReal',
                                                'compuesta.Cantidad',
                                                'compuesta.TipoMonedaId',
                                                DB::raw("DATE_FORMAT(compuesta.Fecha1, '%d/%m/%y') as Fecha1"),
                                                DB::raw("DATE_FORMAT(compuesta.Fecha2, '%d/%m/%y') as Fecha2")
                                                ) 
                                    ->join('consolidado_mes', 'consolidado_mes.Id', '=', 'solicitud.ConsolidadoMesId')
                                    ->join('centro_de_costo', 'centro_de_costo.Id', '=', 'solicitud.CentroCostoId')
                                    ->join('empresa', 'empresa.Id', '=', 'centro_de_costo.EmpresaId')
                                    ->join('historial_solicitud', 'historial_solicitud.SolicitudId','=','solicitud.Id')
                                    ->join('compuesta', 'compuesta.SolicitudId','=','solicitud.Id')
                                    ->join('movimiento_atributo', 'movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
                                    ->join('atributo', 'atributo.Id','=','movimiento_atributo.AtributoId')
                                    ->join('movimiento', 'movimiento.Id','=','movimiento_atributo.MovimientoId')
                                    ->where('historial_solicitud.EstadoEtapaFlujoId','=', 1)
                                    ->where('historial_solicitud.EstadoSolicitudId','=', 3)
                                    ->where('solicitud.ConsolidadoMesId', $consolidadoId)
                                    ->where('solicitud.CentroCostoId', '=', $ccId)
                                    ->where('movimiento_atributo.AtributoId','=', $atributo)
                                    ->orderBy('solicitud.Id','asc');

            if($movId == null){
                $querySolicitud = $querySolicitud->get();
            }else{
                $querySolicitud = $querySolicitud->where('movimiento_atributo.MovimientoId','=', $movId )->get();  
            }
                                               
            return response()->json([
                'success' => true,
                'data'=> $querySolicitud,
                'message' => 'Empresa Guardada'
            ],201);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }    
    }

    public function VerSolicitudesAsociadas(Request $request){
        

        try{
            $request = $request->input('data');
            $consolidadoId = $request['ConsolidadoId'];
            $ccId = $request['a'];
            $movId = $request['MovId'];

            $solicitudes= $this->getSolicitudesAprobadas($consolidadoId,$ccId, $movId);
            
            return response()->json([
                'success' => true,
                'solicitudes'=> $solicitudes,
                'message' => 'Empresa Guardada'
            ],201);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]); 
        }
    }

    public function getSolicitudesAprobadas($consolidadoId,$ccId, $movId){
        
        $solicitudes= Solicitud::querySolicitudes();
                        $solicitudes->where('historial_solicitud.EstadoSolicitudId','=', 3) //Solicitud Terminada
                                    ->where('historial_solicitud.EstadoEtapaFlujoId','=', 1) //Flujo Aprobado
                                    ->where('solicitud.ConsolidadoMesId','=', $consolidadoId)
                                    ->where('solicitud.CentroCostoId','=',$ccId)
                                    ->orderBy('solicitud.Id','asc');
        if($movId != null) {
            $solicitudes = $solicitudes->where('movimiento_atributo.MovimientoId','=', $movId)->get();
        }else{
            $solicitudes = $solicitudes->get();
        }
        return $solicitudes;
    }

    public function Calcular($consolidado){      
        try{
             //fecha actual para el valor de la moneda
            $fecha = date('d-m-Y');
            //SI YA EXISTE UNA ACTUALIZACION EN EL DIA DE HOY, NO CONSULTAR A LA API         
                if( $consolidado->updated_at == null || $consolidado->updated_at->format('d-m-Y') != $fecha){
                    // Obtener el número del día de la semana (0 para domingo, 1 para lunes, ..., 6 para sábado)
                    $dia_semana = date('w', strtotime($fecha));
                    // Si es sábado (6) o domingo (0), ajustar la fecha al próximo lunes
                    //Limitancia Sabado o Domingo, se elije el dia lunes
                    if ($dia_semana == 6 || $dia_semana == 0) {
                        $fecha = date('d-m-Y', strtotime('next Monday', strtotime($fecha)));
                    }
                    DB::beginTransaction();
                    //obtiene valor del dolar y uf desde miindicador.cl
                    //Llamada API obtencion de valores dolar y uf
                    $dolar = TipoCambio::CreaMoneda('/dolar/'.$fecha , 2, $consolidado->Id);
                    $uf = TipoCambio::CreaMoneda('/uf/'.$fecha , 3, $consolidado->Id);
                    if(!$dolar || !$uf){
                        throw new Exception('Error al capturar el valor de las monedas');                    
                    }

                    /* CONSULTA ANTIGUA SIN OPTIMIZAR
                    $time_start = microtime(true);
                    $solicitudes = Solicitud::select('solicitud.Id',
                                                DB::raw('CONCAT("[", GROUP_CONCAT(JSON_OBJECT("CostoReal", compuesta.CostoReal, "TipoMonedaId", compuesta.TipoMonedaId)), "]") as compuesta'),

                                            )
                                            ->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')
                                            ->join('historial_solicitud','historial_solicitud.SolicitudId','=','solicitud.Id')          
                                            ->where('solicitud.ConsolidadoMesId',$consolidado->Id)
                                            ->where('historial_solicitud.EstadoSolicitudId','=',3) //Solicitud Terminada
                                            ->where('historial_solicitud.EstadoEtapaFlujoId','=', 1) //Etapada Aprobada
                                            ->groupBy('solicitud.Id')
                                            ->orderBy('solicitud.Id','asc')
                                            ->get();

                    //Realiza la sumatoria de cada solicitud, transformando la moneda a CLP$
                    foreach($solicitudes as $solicitud){
                        $suma = 0;
                        $solicitud->compuesta = json_decode($solicitud->compuesta);       
                        foreach($solicitud->compuesta as $compuesta){
                            if($compuesta->TipoMonedaId == 1 && $compuesta->CostoReal != null){
                                $suma += $compuesta->CostoReal;
                            }else if($compuesta->TipoMonedaId == 2 && $compuesta->CostoReal != null){
                                $suma += $compuesta->CostoReal * $dolar->ToCLP;
                            }else if($compuesta->TipoMonedaId == 3 && $compuesta->CostoReal != null){
                                $suma += $compuesta->CostoReal * $uf->ToCLP;
                            }
                        }
                    Solicitud::where( 'Id', $solicitud->Id)
                                    ->update([
                                        'CostoSolicitud' => $suma,
                                        'TipoMonedaId' => 1
                                    ]);          
                    }   
                    $time_end = microtime(true);
                    $time = $time_end - $time_start;
                    */
                    
                    //CONSULTA OPTIMIZADA
                    ///Recibe las solicitudes terminadas correspondientes al mes que esten y aprobadas
                    $time_start = microtime(true);
                    $solicitudes = Solicitud::select('solicitud.Id',
                                            DB::raw('SUM(
                                                        CASE 
                                                            WHEN compuesta.TipoMonedaId = 1 AND compuesta.CostoReal IS NOT NULL THEN compuesta.CostoReal
                                                            WHEN compuesta.TipoMonedaId = 2 AND compuesta.CostoReal IS NOT NULL THEN compuesta.CostoReal * '.$dolar.'
                                                            WHEN compuesta.TipoMonedaId = 3 AND compuesta.CostoReal IS NOT NULL THEN compuesta.CostoReal * '.$uf.'
                                                            ELSE 0
                                                        END
                                                        ) AS CostoSolicitud'))
                                            ->join('compuesta', 'compuesta.SolicitudId', '=', 'solicitud.Id')
                                            ->join('historial_solicitud', 'historial_solicitud.SolicitudId', '=', 'solicitud.Id')
                                            ->where('solicitud.ConsolidadoMesId', $consolidado->Id)
                                            ->where('historial_solicitud.EstadoSolicitudId', '=', 3) // Solicitud Terminada
                                            ->where('historial_solicitud.EstadoEtapaFlujoId', '=', 1) // Etapada Aprobada
                                            ->groupBy('solicitud.Id')
                                            ->orderBy('solicitud.Id', 'asc')
                                            ->get();
                                            
                    foreach ($solicitudes as $solicitud) {
                        Solicitud::where('Id', $solicitud->Id)
                                    ->update([
                                        'CostoSolicitud' => $solicitud->CostoSolicitud,
                                        'TipoMonedaId' => 1
                                    ]); 
                    } 
                    
                    $time_end = microtime(true);
                    $time = $time_end - $time_start;
                    DB::commit();
                }           
            return true;
        }
        catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al previsualizar el cierre de mes',[$e->getMessage()]);
            return false;     
        }
    }

    public function CerrarMes(Request $request){ 
        try{
            //Busca el consolidado abierto (EstadoConsolidadoId = 1)
            $consolidado = ConsolidadoMe::where('EstadoConsolidadoId',1)
                            ->first();
            DB::beginTransaction();
            if( !$this->Calcular($consolidado) ){ throw new Exception('Error al Calcular');};
            
                //Cierra el mes cambiando de estado y agregando la fecha de término
            $consolidado->EstadoConsolidadoId = 0;
            $consolidado->FechaTermino = Carbon::now();
            $consolidado->update();

            //Crea un nuevo mes con la fecha y hora actual, con un estado abierto
            $nuevoConsolidadoMes = new ConsolidadoMe();
            $nuevoConsolidadoMes->EstadoConsolidadoId = 1;
            $nuevoConsolidadoMes->created_at = Carbon::create($consolidado->created_at)->addMonth()->startOfMonth();
            $nuevoConsolidadoMes->save();
            $time_start = microtime(true);
            /*Consulta antigua 
            //Buscar Solicitudes Pendientes para pasarlas al siguiente consolidado
            $solicitudesPendientes = Solicitud::select('solicitud.Id')
                                            ->join('historial_solicitud','historial_solicitud.SolicitudId','=','solicitud.Id')          
                                            ->where('solicitud.ConsolidadoMesId',$consolidado->Id)
                                            ->where('historial_solicitud.EstadoEtapaFlujoId','=', 3) //Etapada Pendiente
                                            ->orderBy('solicitud.Id','asc')
                                            ->pluck('solicitud.Id')->toArray();

            Solicitud::whereIn( 'Id', $solicitudesPendientes)
                            ->update([
                                'ConsolidadoMesId' => $nuevoConsolidadoMes->Id
                            ]);  
            */

            //* Consulta Optimizada
            // Actualizar las solicitudes pendientes en una sola consulta
            Solicitud::whereIn('Id', function ($query) use ($consolidado) {
                                $query->select('solicitud.Id')
                                    ->from('solicitud')
                                    ->join('historial_solicitud', 'historial_solicitud.SolicitudId', '=', 'solicitud.Id')
                                    ->where('solicitud.ConsolidadoMesId', $consolidado->Id)
                                    ->where('historial_solicitud.EstadoEtapaFlujoId', '=', 3); // Etapada Pendiente
                            })->update(['ConsolidadoMesId' => $nuevoConsolidadoMes->Id]);             
            
            
            $time_end = microtime(true);
            $time = $time_end - $time_start;               
            Log::info('Mes cerrado');
            DB::commit();
            return response()->json([
                'success'=>true,
                'mensaje'=>'Mes cerrado correctamente'
            ]);
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error('Error al cerrar mes',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'mensaje' =>$e->getMessage()
            ]);
        }
    }
}
