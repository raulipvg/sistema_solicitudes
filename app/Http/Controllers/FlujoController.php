<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\EstadoFlujo;
use App\Models\Flujo;
use App\Models\Grupo;
use App\Models\OrdenFlujo;
use App\Models\Persona;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlujoController extends Controller
{
    public function Index(){

        $areas= Area::select('Id','Nombre')
                    ->where('Enabled',1)
                    ->get();
                    
        $grupos= Grupo::select('Id','Nombre')
                    ->where('Enabled',1)
                    ->get();
        $estados = EstadoFlujo::select('Id','Nombre')
                    ->where('Enabled',1)
                    ->where('Id','!=',1)
                    ->get();


        return view('flujo.flujo')->with([
            'titulo'=> 'Flujos',
            'areas' => $areas,
            'grupos'=> $grupos,
            'estados'=> $estados
        ]);
    }

    public function Guardar(Request $request){
    
        $request = $request->input('data');
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Enabled'] =1;

        try{
            $flujo = new Flujo();
            //$usuario->validate($request);
            $flujo->fill($request);

            DB::beginTransaction();

            $flujo->save(); 

            foreach ($request['ordenFlujo'] as $ordenFlujo) {
                $obj = new OrdenFlujo();
                $obj->Nivel = $ordenFlujo['Nivel'];
                $obj->EstadoFlujoId =$ordenFlujo['EstadoFlujoId'];
                $obj->Pivot = $ordenFlujo['Pivot'];
                $obj->FlujoId = $flujo->Id;
                $obj->save();
            }
            Log::info('Nuevo FLujo Id: '.$flujo->Id);
            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Usuario y Persona Guardada'
            ],201);
        }catch(Exception $e){  
            DB::rollBack();

            Log::error('Error al crear usuario: '.$flujo->Nombre, [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }
    
    }
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
