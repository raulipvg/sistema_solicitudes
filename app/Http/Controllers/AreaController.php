<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function Index()
    {
        $titulo= "Areas";
        $areas = Area::all();

        return view('area.area')->with([
                        'titulo'=> $titulo,
                        'areas'=> $areas
                    ]);
    
    }
      /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Descripcion'] = strtolower($request['Descripcion']);

        try{
            $area = new Area();
            $area->validate($request);
            $area->fill($request);
            
            DB::beginTransaction();

            $area->save(); 

            DB::commit(); 
            
            return response()->json([
                'success' => true,
                'message' => 'Area Guardada'
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
            $area= Area::find($request);

            if (!$area) {
                throw new Exception('Area no encontrada');
            }

            return response()->json([
                'success' => true,
                'data' => $area
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
        $request['Descripcion'] = strtolower($request['Descripcion']);

         try{
            $area = new Area();
            $area->validate($request);

            DB::beginTransaction();

            $areaEdit = Area::find($request['Id']);
            if (!$areaEdit) {
                throw new Exception('Area no encontrada');
            }

            $areaEdit->fill($request);
            $areaEdit->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Area actualizada correctamente'
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
            $areaEdit = Area::find($request);

            if (!$areaEdit) {
                throw new Exception('Area no encontrada');
            }
            DB::beginTransaction();
            $areaEdit->update([
                   'Enabled' => ($areaEdit['Enabled'] == 1)? 0: 1 
            ]);
            $areaEdit->save();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado del Area cambiado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function VerFlujos(Request $request)
    {
        //POR HACER::CUANDO ESTEN LISTOS LOS FLUJOS
        return response()->json([
            'success' => true,
            'message' => 'Ver FLujos asociados al Area']);
    }

}
