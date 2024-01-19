<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Flujo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    public function Index()
    {
        $titulo= "Areas";
        //$areas = Area::all();

        $areas = Area::select('Id','Nombre','Descripcion','created_at','Enabled')->get();

        Log::info('Ingreso vista Area');
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
            Log::info('Nueva Area: '.$area->Id); 
            
            return response()->json([
                'success' => true,
                'area'=> [[
                    'Id'=> $area->Id,
                    'Nombre'=> $area->Nombre,
                    'Descripcion'=> $area->Descripcion,
                    'created_at'=> $area->created_at,
                    'Enabled' => $area->Enabled
                ]],
                'message' => 'Area Guardada'
            ],201);
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
            ],200);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
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
            Log::info('Se modificó el area Id: '.$areaEdit->Id);
            return response()->json([
                'success' => true,
                'area'=> [[
                    'Id'=> $areaEdit->Id,
                    'Nombre'=> $areaEdit->Nombre,
                    'Descripcion'=> $areaEdit->Descripcion,
                    'created_at'=> $areaEdit->created_at,
                    'Enabled' => $areaEdit->Enabled
                ]],
                'message' => 'Area actualizada correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar area:', [$e]);  
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
        $request = $request->input('data');
        //POR HACER::CUANDO ESTEN LISTOS LOS FLUJOS
        $flujos = Flujo::select('Id','Nombre','created_at')
                            ->where('AreaId','=', $request)
                            ->get();
        return response()->json([
            'success' => true,
            'data'=> $flujos,
            'message' => 'Ver FLujos asociados al Area']);
    }

}
