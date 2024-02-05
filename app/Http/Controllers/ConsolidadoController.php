<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\ConsolidadoMe;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Solicitud;
use App\Models\TipoCambio;
use Exception;
use Illuminate\Support\Facades\DB;

class ConsolidadoController extends Controller
{
    public function Index (Request $request){
        $titulo= "Consolidado Mensual de solicitudes";
        //$usuarios = Usuario::all();

        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        $accesoLayout= $user->todoPuedeVer();

        $movimientos = Movimiento::select('Id','Nombre','Enabled')->get();
        $empresas = Empresa::select('Id','Nombre','Enabled')->get();
        $centrocostos = CentroDeCosto::select('Id','Nombre','Enabled')->get();
        $consolidados = ConsolidadoMe::select('Id',
                                                DB::raw('DATE_FORMAT(created_at, "%m - %Y") AS Mes')
                                            )
                                            ->orderBy('Mes','desc')
                                            ->get(); 

        return view('consolidado.consolidado')->with([
            'accesoLayout'=>$accesoLayout,
            'titulo' => $titulo,
            'movimientos' => $movimientos,
            'empresas'=> $empresas,
            'centrocostos'=> $centrocostos,
            'consolidados'=> $consolidados
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
        $empresaId = $request['Empresa'];
        $ccId = $request['CC'];
        $movimientoId = $request['Movimiento'];
        $consolidadoId = $request['Consolidado'];

        $tipoCambio = TipoCambio::select('ToCLP','TipoMonedaId')
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
        }
        else if ($ccId != null && $movimientoId == null) {
            if ($empresaId == null || $empresaId != null) {
                $querySolicitud = $querySolicitud->where('solicitud.CentroCostoId', '=', $ccId)->get();
            }
        }

        return response()->json([
            'success' => true,
            'querySolicitud' => $querySolicitud,
            'tipoCambio'=> $tipoCambio
            ]);


    }
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
    public function VerDetallesAsociados(Request $request){
        //DETALLES ASOCIADOS
        $request = $request->input('data');
        try{
            
            $ccId= $request['a']; 
            $atributo = $request['b']; 
            $consolidadoId = $request['c'];
            $querySolicitud = Solicitud::select( 'solicitud.Id as SolicitudId', 'movimiento.Nombre as Movimiento','compuesta.Caracteristica as Detalle') 
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
                                    ->orderBy('solicitud.Id','asc')
                                    ->get();            
        
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

            $solicitudes= $this->getSolicitudesAprobadas($consolidadoId,$ccId);
            
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

    public function getSolicitudesAprobadas($consolidadoId,$ccId){
        
        $solicitudes= Solicitud::select('solicitud.Id',DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"),
																	'centro_de_costo.Nombre as CentroCosto','FechaDesde','FechaHasta',
																	'solicitud.created_at as FechaCreado','historial_solicitud.EstadoSolicitudId',
																	'estado_flujo.Nombre as EstadoFlujo', 'movimiento.Nombre as Movimiento',
																	'flujo.Nombre as NombreFlujo','flujo.Id as FlujoIdd','orden_flujo.GrupoId as GrupoAprobadorId',
																	'historial_solicitud.Id as HistorialId',
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
															->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')                                
															->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
															->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
															->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
															->join('flujo','flujo.Id','=','movimiento.FlujoId')
															->join('orden_flujo','orden_flujo.FlujoId','=','flujo.Id')
															->where('orden_flujo.EstadoFlujoId', '=', DB::raw('estado_flujo.Id'))
															->groupBy('solicitud.Id', 'NombreCompleto', 'CentroCosto', 'FechaDesde', 'FechaHasta', 'FechaCreado', 'EstadoSolicitudId', 
															'EstadoFlujo', 'Movimiento', 'NombreFlujo', 'HistorialId','FlujoIdd','UsuarioSolicitanteId','GrupoAprobadorId')
															->where('historial_solicitud.EstadoSolicitudId','=', 3) //Solicitud Terminada
                                                            ->where('historial_solicitud.EstadoEtapaFlujoId','=', 1) //Flujo Aprobado
                                                            ->where('solicitud.ConsolidadoMesId','=', $consolidadoId)
                                                            ->where('solicitud.CentroCostoId','=',$ccId)
                                                            ->orderBy('solicitud.Id','asc')
										                    ->get();
        return $solicitudes;
    }
}
