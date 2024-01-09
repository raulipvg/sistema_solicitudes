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
            'grupos' => $grupos
        ]);
        
    }

    public function Guardar(Request $request){
        
        $request = $request->input('data');

        try{
            $movimiento = Movimiento::find($request['MovimientoId']);
            if(!$movimiento) throw new Exception('Error: Movimiento no encontrado');
            DB::beginTransaction();
            
            foreach($request['AtributoId'] as $atributoId){

                if(!Atributo::find($atributoId)) throw new Exception('Error: uno de los atributos no fue encontrado');
                $movimientoAtr = new MovimientoAtributo();
                $movimientoAtr['AtributoId'] = $atributoId;
                $movimientoAtr['MovimientoId'] = $request['MovimientoId'];
                $movimientoAtr->save();
            }

            DB::commit();
            Log::info('Se asignaron atributos al movimiento '.$movimiento->Nombre);
            return response()->json([
                'success' => true,
                'message' => 'Atributos asignados a este movimiento'
            ]);
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error('Intento de asignar atributos a '.$movimiento->Nombre, [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function AtributosAsociados(Request $request){
        $request = $request->data('input');

        try{

            $movimientoExiste = Movimiento::find($request);

            if(!$movimientoExiste) throw new Exception('Movimiento no encontrado');

            $atributosNoAsociados = MovimientoAtributo::select('AtributoId')
                                ->where('MovimientoId', $request)
                                ->where('Enabled',1)
                                ->pluck('AtributoId') // Utiliza pluck para obtener solo los valores de 'Id'
                                ->toArray();
            
            $atributosNoAsociados = Atributo::select('Id', 'Nombre')
                                    ->where('Enabled', 1)
                                    ->whereNotIn('Id', $atributosNoAsociados)
                                    ->get();

            return response()->json([
                'success' => true,
                'data' => $atributosNoAsociados,
                'nombre' => $movimientoExiste->persona->Nombre, 
                'message' => 'Modelo recibido y procesado'
            ]);
        
        }
        catch(Exception $e){
            Log::error('No se pudo acceder a los atributos de un movimiento Id:'.$request, [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
