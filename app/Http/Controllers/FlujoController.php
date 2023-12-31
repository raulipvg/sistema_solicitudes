<?php

namespace App\Http\Controllers;

use App\Models\Flujo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlujoController extends Controller
{
    public function Eliminar(Request $request)
    {
        $request = $request->input('data');
        
        try{
            $flujoEdit = Flujo::find($request);

            if (!$flujoEdit) {
                throw new Exception('Flujo no encontrado');
            }
            DB::beginTransaction();
            $flujoEdit->update([
                   'Enabled' => ($flujoEdit['Enabled'] == 1)? 0: 1 
            ]);
            $flujoEdit->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Flujo desvinculado del Area'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
    
        }
    }
}
