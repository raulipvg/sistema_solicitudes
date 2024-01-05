<?php

namespace App\Http\Controllers;

use App\Models\Atributo;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\MovimientoAtributo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class MovimientoAtributoController extends Controller
{
    public function Index(){
        $titulo = 'Movimientos y Atributos';

        $movimientos = Movimiento::select('Id','Nombre')
                                    ->where('Enabled',1)
                                    ->get();
        $atributos = Atributo::select('Id', DB::raw('CONCAT(UPPER(Nombre), " - $", FORMAT(ValorReferencia, 0, "es_CL")) as Nombre'))
                                ->where('Enabled',1)
                                ->get();
        Log::info('Ingreso vista movimiento-atributo');

        return View('movimientoatributo.movimientoatributo')->with([
            'titulo' => $titulo,
            'movimientos' => $movimientos,
            'atributos' => $atributos
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
}
