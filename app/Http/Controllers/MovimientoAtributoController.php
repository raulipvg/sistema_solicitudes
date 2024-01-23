<?php

namespace App\Http\Controllers;

use App\Models\Atributo;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Flujo;
use App\Models\Grupo;
use App\Models\MovimientoAtributo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class MovimientoAtributoController extends Controller
{
    public function Index(){
        $titulo = 'Movimientos y Atributos';

        $user = auth()->user();
        // 10 Privilegios de Movimiento
        $credenciales = [
                'puedeVer'=> $user->puedeVer(10),
                'puedeRegistrar'=> $user->puedeRegistrar(10),
                'puedeEditar'=> $user->puedeEditar(10),
                'puedeEliminar'=> $user->puedeEliminar(10),
        ];

        $movimientos= Movimiento::select(
                                'movimiento.Id',
                                'movimiento.Nombre',
                                'grupo.Nombre as Grupo' ,
                                'flujo.Nombre as Flujo',
                                'movimiento.Enabled as Enabled'
                            )
                            ->join('grupo','grupo.Id', '=', 'movimiento.GrupoId')
                            ->join('flujo','flujo.Id','=','movimiento.FlujoId')
                            ->get();
        $atributosSelect = Atributo::select('Id', DB::raw('CONCAT(UPPER(Nombre), " - $", FORMAT(ValorReferencia, 0, "es_CL")) as Nombre'))
                                ->where('Enabled',1)
                                ->get();

        $flujos=Flujo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
        $grupos=Grupo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();

        $atributos = Atributo::select('Id','Nombre','ValorReferencia','Enabled')->get();

        Log::info('Ingreso vista movimiento-atributo');

        return View('movimientoatributo.movimientoatributo')->with([
            'titulo' => $titulo,
            'movimientos' => $movimientos,
            'atributosSelect' => $atributosSelect,
            'atributos' => $atributos,
            'flujos' => $flujos,
            'grupos' => $grupos,
            'credenciales' => $credenciales
        ]);
        
    }

    public function Guardar(Request $request){
        
        $request = $request->input('data');

        try{
            $movimiento = Movimiento::find($request['MovimientoId']);
            if(!$movimiento) throw new Exception('Error: Movimiento no encontrado');
            $atributos = [];
            DB::beginTransaction();
            
            foreach($request['AtributoId'] as $atributoId){
                $atributo = Atributo::find($atributoId);
                if(!$atributo) throw new Exception('Error: uno de los atributos no fue encontrado');
                $movimientoAtr = new MovimientoAtributo();
                $movimientoAtr['AtributoId'] = $atributoId;
                $movimientoAtr['MovimientoId'] = $request['MovimientoId'];
                $movimientoAtr->save();
                $atributos[] = $atributo;
            }

            

            DB::commit();
            Log::info('Se asignaron atributos al movimiento '.$movimiento->Nombre);
            return response()->json([
                'success' => true,
                'message' => 'Atributos asignados a este movimiento',
                'data' => $atributos
            ]);
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error('Intento fallido de asignar atributos a '.$movimiento->Nombre, [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function Ver(Request $request){
        $movimientoId = $request->input('data');

        try{
            $movimientoExiste= Movimiento::find($movimientoId);
            if (!$movimientoExiste) {
                throw new Exception('Movimiento no encontrado');
            }
            $movimientoAtributo = MovimientoAtributo::select('movimiento_atributo.Id', 'atributo.Nombre', 'atributo.ValorReferencia', 'atributo.Caracteristica')
                                        ->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
                                        ->where('movimiento_atributo.MovimientoId', $movimientoId)
                                        ->where('atributo.Enabled', 1)
                                        ->get();
            Log::info('Ver atributos del movimiento #'.$movimientoId);
            return response()->json([
                'success' => true,
                'data' => $movimientoAtributo,
                'movimiento'=> $movimientoExiste->Id 
            ]);

        }catch(Exception $e){
            Log::error('Error al ver atributos de movimiento #'. $movimientoId, [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function AtributosFaltantes(Request $request){
        $request = $request->input('data');

        $movimientoExiste = Movimiento::find($request);
        if (!$movimientoExiste) {
            throw new Exception('Movimiento no encontrado');
        }
        $atributosAsociados = MovimientoAtributo::select('AtributoId')
                                ->where('MovimientoId', $movimientoExiste['Id'])
                                ->pluck('AtributoId') // Utiliza pluck para obtener solo los valores de 'Id'
                                ->toArray();

        $atributosNoAsociados = Atributo::select('Id', 'Nombre')
                                    ->where('Enabled', 1)
                                    ->whereNotIn('Id', $atributosAsociados)
                                    ->get();
        $movimientos= Movimiento::select(
                                    'Id',
                                    'Nombre',
                                )
                                ->where('Enabled',1)
                                ->orWhere('Id', '=', $movimientoExiste->Id)
                                ->get();

        return response()->json([
            'success' => true,
            'data' => $atributosNoAsociados,
            'nombre' => $movimientoExiste->Nombre, 
            'message' => 'Modelo recibido y procesado',
            'movimientos' => $movimientos
        ]);

    }
}
