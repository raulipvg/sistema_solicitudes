<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Flujo;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;


class MovimientoController extends Controller
{
    public function Index()
    {
        $titulo= "Movimiento";
        $movimientos= Movimiento::all();
        $flujos=Flujo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
        $grupos=Grupo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
        return view('movimiento.movimiento')->with([
                        'titulo'=>$titulo,
                        'movimientos'=>$movimientos,
                        'flujos'=>$flujos,
                        'grupos'=>$grupos
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);

        try{
            $movimiento = new Movimiento();
            $movimiento->validate($request);
            $movimiento->fill($request);

            DB::beginTransaction();

            $movimiento->save();

            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Movimiento Guardado'
            ]);
        }catch(Exception $e){  
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function VerId(Request $request)
    {
        $request = $request->input('data');

        try{
            $movimiento = Movimiento::find($request);

            if(!$movimiento){
                throw new Exception('Movimiento no encontrado');
            }

            return response()->json([
                'success' => true,
                'data' => $movimiento
            ]);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function Editar(Request $request)
    {
        $request = $request->input('data');
        
        $request['Nombre'] = strtolower($request['Nombre']);

        try{
            $movimiento = new Movimiento();
            $movimiento ->validate($request);

            DB::beginTransaction();

            $movimientoEdit = Movimiento::find($request['Id']);

            if(!$movimientoEdit){
                throw new Exception('Movimiento no encontrado');
            }

            $movimientoEdit->fill($request);
            $movimientoEdit->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Movimiento actualizado correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function CambiarEstado(Request $request)
    {
        $request = $request->input('data');

        try{
            $movimientoEdit = Movimiento::find($request);

            if(!$movimientoEdit){
                throw new Exception('Empresa no encontrada');
            }

            DB::beginTransaction();

            $movimientoEdit->update([
                'Enabled' => ($movimientoEdit['Enabled'] == 1) ? 0 : 1
            ]);

            $movimientoEdit->save();

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado de la Empresa cambiado'
            ]);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    
    }
}
