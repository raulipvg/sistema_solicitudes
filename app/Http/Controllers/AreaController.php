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
        
        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        // 6 Privilegios de Area
        $credenciales = [
                'puedeVer'=> $user->puedeVer(6),
                'puedeRegistrar'=> $user->puedeRegistrar(6),
                'puedeEditar'=> $user->puedeEditar(6),
                'puedeEliminar'=> $user->puedeEliminar(6),
        ];
        // 7 Privilegios de Flujo
        $credenciales2 = [
                'puedeVer'=> $user->puedeVer(7),
                'puedeRegistrar'=> $user->puedeRegistrar(7),
                'puedeEditar'=> $user->puedeEditar(7),
                'puedeEliminar'=> $user->puedeEliminar(7),
        ];
        $accesoLayout= $user->todoPuedeVer();
        //END::PRIVILEGIOS

        $areas = Area::select('Id','Nombre','Descripcion','created_at','Enabled')->get();

        Log::info('Ingreso vista Area');
        return view('area.area')->with([
                        'titulo'=> $titulo,
                        'areas'=> $areas,
                        'credenciales'=> $credenciales,
                        'credenciales2'=> $credenciales2,
                        'accesoLayout' => $accesoLayout
                    ]);
    
    }
    public function Ver(Request $request){
        try {
            $areas = Area::select('Id','Nombre','Descripcion','created_at','Enabled')->get();
            
            Log::info('Ver información del área');
            return response()->json([
                'success' => true,
                'data' => $areas
            ],200);
        } catch (Exception $e) {
            Log::error('Error al ver información del área',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
        }

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
            Log::info('Nueva Area'); 
            
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
            Log::error('Error al guardar un área.',[$e]);
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
            Log::info('Ver información del área');
            return response()->json([
                'success' => true,
                'data' => $area
            ],200);

        }catch(Exception $e){
            Log::error('Error al ver información del área',[$e->getMessage()]);
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
            Log::info('Se modificó el area');
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
            Log::error('Error al modificar area', [$e->getMessage()]);  
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
            Log::info('Cambio de estado en área');
            return response()->json([
                'success' => true,
                'message' => 'Estado del Area cambiado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al cambiar estado del área',[$e->getMessage()]);
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
                            ->where('Enabled','=', 1)
                            ->get();
        return response()->json([
            'success' => true,
            'data'=> $flujos,
            'message' => 'Ver FLujos asociados al Area']);
    }

}
