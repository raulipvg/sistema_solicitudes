<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Flujo;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MovimientoController extends Controller
{
    public function Index()
    {
        $titulo= "Movimiento";
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
        
        $flujos=Flujo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
        $grupos=Grupo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
        return view('movimiento.movimiento')->with([
                        'titulo'=>$titulo,
                        'movimientos'=>json_encode( $movimientos),
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

            Log::info('Nuevo movimiento #'.$movimiento->Id);
            return response()->json([
                'success' => true,
                'movimiento' => [[
                    'Id' => $movimiento->Id,
                    'Nombre' => $movimiento->Nombre,
                    'Grupo' => $movimiento->grupo->Nombre,
                    'Flujo' => $movimiento->flujo->Nombre,
                    'Enabled' => $movimiento->Enabled
                ]]
            ]);
        }catch(Exception $e){  
            DB::rollBack();
            Log::error('Error al guardar movimiento', [$e]);
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

            $flujos=Flujo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->orWhere('Id', '=', $movimiento->FlujoId)
                    ->get();
            $grupos=Grupo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->orWhere('Id', '=', $movimiento->GrupoId)
                    ->get();
            Log::info('Ver información del movimiento #'.$request);
            return response()->json([
                'success' => true,
                'data' => [
                    'Id' => $movimiento->Id,
                    'Nombre' => $movimiento->Nombre,
                    'GrupoId' => $movimiento->GrupoId,
                    'FlujoId' => $movimiento->FlujoId,
                    'Enabled' => $movimiento->Enabled,
                    'grupos' => $grupos,
                    'flujos' => $flujos
                ]
            ]);

        }catch(Exception $e){
            Log::error('Error al ver información de movimiento', [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function VerGruposFlujos(){
        
        try{
            $flujos=Flujo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
            $grupos=Grupo::select('Id', 'Nombre')
                    ->where('Enabled','=',1)
                    ->get();
            return response()->json([
                'success' => true,
                'flujos' => $flujos,
                'grupos' => $grupos
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
            Log::info('Modificación al movimiento #'.$request['Id']);
            return response()->json([
                'success' => true,
                'movimiento' => [[
                    'Id' => $movimientoEdit->Id,
                    'Nombre' => $movimientoEdit->Nombre,
                    'Grupo' => $movimientoEdit->grupo->Nombre,
                    'Flujo' => $movimientoEdit->flujo->Nombre,
                    'Enabled' => $movimientoEdit->Enabled
                ]]
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar movimiento', [$e]);
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
            Log::info('Cambio de estado de movimiento #'.$request);
            return response()->json([
                'success' => true,
                'message' => 'Estado de la Empresa cambiado'
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar estado de movimiento',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    
    }
}
