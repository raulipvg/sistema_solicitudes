<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CentroCostoController extends Controller
{
    public function Guardar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Enabled'] =1;
        try{

            $empresaExiste = Empresa::find($request['EmpresaId']);
            if (!$empresaExiste) {
                throw new Exception('Empresa no encontrada');
            }

            $centrocosto = new CentroDeCosto();
            $centrocosto->validate($request);
            $centrocosto->fill($request);
            
            DB::beginTransaction();

            $centrocosto->save();

            DB::commit(); 
            return response()->json([
                'success' => true,
                'data'=> [
                    'Nombre'=> $centrocosto->Nombre,
                    'Id'=> $centrocosto->Id,
                    'created_at'=> $centrocosto->created_at,
                ],
                'message' => 'Centro de Costo Guardado'
            ]);
        }catch(Exception $e){  
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }
    }

    public function CambiarEstado(Request $request)
    {
        $request = $request->input('data');

        try{
            $centroCostoEdit = CentroDeCosto::find($request);

            if (!$centroCostoEdit) {
                throw new Exception('Centro de Costo no encontrado');
            }
            DB::beginTransaction();
            $centroCostoEdit->update([
                   'Enabled' => ($centroCostoEdit['Enabled'] == 1)? 0: 1 
            ]);
            $centroCostoEdit->save();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado del Centro de Costo cambiado'
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
