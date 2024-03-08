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
        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        // 7 Privilegios de Flujo
        $credenciales['Flujo']=  [
                'puedeVer'=> $user->puedeVer(7),
                'puedeRegistrar'=> $user->puedeRegistrar(7),
                'puedeEditar'=> $user->puedeEditar(7),
                'puedeEliminar'=> $user->puedeEliminar(7),
        ];
        // 6 Privilegios de Area
        $credenciales['Area']= [
            'puedeVer'=> $user->puedeVer(6),
            'puedeRegistrar'=> $user->puedeRegistrar(6),
            'puedeEditar'=> $user->puedeEditar(6),
            'puedeEliminar'=> $user->puedeEliminar(6),
        ];
        // 8 Privilegios de Estado de Flujo
        $credenciales['EstadoFlujo'] = [
            'puedeVer'=> $user->puedeVer(8),
            'puedeRegistrar'=> $user->puedeRegistrar(8),
            'puedeEditar'=> $user->puedeEditar(8),
            'puedeEliminar'=> $user->puedeEliminar(8),
        ];

        $accesoLayout= $user->todoPuedeVer();

        return view('flujo.index')->with([
            'titulo'=> 'Flujos',
            'credenciales'=> $credenciales,
            //'credenciales2'=> $credenciales2,
            'accesoLayout' => $accesoLayout 
        ]);
    }

    public function Ver(Request $request){
        try {
            $flujos = Flujo::select('flujo.Id', 'flujo.Nombre', 'flujo.Enabled', 'area.Nombre as AreaNombre',
                                DB::raw('(SELECT CONCAT("[", GROUP_CONCAT(JSON_OBJECT("Nombre", estado_flujo.Nombre, "OrdenFlujoId", orden_flujo.Id) ORDER BY orden_flujo.Id), "]")
                                FROM orden_flujo 
                                JOIN estado_flujo ON estado_flujo.Id = orden_flujo.EstadoFlujoId 
                                WHERE orden_flujo.FlujoId = flujo.Id) as Etapa')
                            )
                            ->join('area', 'area.Id', '=', 'flujo.AreaId')
                            ->join('orden_flujo', 'orden_flujo.FlujoId', '=', 'flujo.Id')                   
                            ->orderBy('flujo.Id','asc')
                            ->groupBy('flujo.Id', 'flujo.Nombre', 'flujo.Enabled', 'area.Nombre')
                            ->get();

            Log::info('Ver Flujos');
            return response()->json([
                'success' => true,
                'data' => $flujos,
                'message' => 'Flujo entregado'
            ],201);
        } catch (Exception $e) {
            Log::error('Error al ver los flujos', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }
    }

    public function VerId(Request $request){
        try {
            $request = $request->input('data');

            $flujos = Flujo::select('flujo.Id', 'flujo.Nombre', 'flujo.Enabled','flujo.GrupoId','flujo.AreaId','area.Nombre as AreaNombre', 
                                    DB::raw('(SELECT CONCAT("[", GROUP_CONCAT(JSON_OBJECT(  "Nombre", estado_flujo.Nombre, 
                                                                                            "OrdenFlujoId", orden_flujo.Id,
                                                                                            "GrupoId", orden_flujo.GrupoId
                                                                                        )ORDER BY orden_flujo.Id), "]")
                                    FROM orden_flujo 
                                    JOIN estado_flujo ON estado_flujo.Id = orden_flujo.EstadoFlujoId 
                                    WHERE orden_flujo.FlujoId = flujo.Id) as Etapa')
                                )
                                ->where('flujo.Id','=',$request)
                                ->join('area', 'area.Id', '=', 'flujo.AreaId')
                                ->join('orden_flujo', 'orden_flujo.FlujoId', '=', 'flujo.Id')                   
                                //->orderBy('flujo.Id','asc')
                                ->groupBy('flujo.Id', 'flujo.Nombre', 'flujo.Enabled','flujo.GrupoId','flujo.AreaId','area.Nombre')
                                ->first();
            $grupos = Grupo::select('Id','Nombre')
                            ->where('Enabled','=',1)
                            ->get();

            $areas = Area::select('Id','Nombre')
                            ->where('Enabled','=',1)
                            ->get();

            Log::info('Ver Flujo');
            return response()->json([
                'success' => true,
                'data' => $flujos,
                'grupos' => $grupos,
                'areas' => $areas,
                'message' => 'Flujo entregado'
            ],201);
        } catch (Exception $e) {
            Log::error('Error al ver Flujo:', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }

    }
    public function Registrar(){

        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        // 7 Privilegios de Empresa
        $credenciales = [
                'puedeVer'=> $user->puedeVer(7),
                'puedeRegistrar'=> $user->puedeRegistrar(7),
                'puedeEditar'=> $user->puedeEditar(7),
                'puedeEliminar'=> $user->puedeEliminar(7),
        ];
        $accesoLayout= $user->todoPuedeVer();
        //END::PRIVILEGIOS

        $areas= Area::select('Id','Nombre')
                    ->where('Enabled',1)
                    ->get();
                    
        $grupos= Grupo::select('Id','Nombre')
                    ->where('Enabled',1)
                    ->get();
        $estados = EstadoFlujo::select('Id','Nombre')
                    ->where('Enabled',1)
                    ->get();

        Log::info('Ingreso vista flujo');
        return view('flujo.registrarflujo')->with([
                        'titulo'=> 'Flujos',
                        'areas' => $areas,
                        'grupos'=> $grupos,
                        'estados'=> $estados,
                        'credenciales'=> $credenciales,
                        'accesoLayout' => $accesoLayout 
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
                $obj->GrupoId = $ordenFlujo['GrupoId'];
                $obj->save();
            }
            Log::info('Nuevo Flujo');
            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Usuario y Persona Guardada'
            ],201);
        }catch(Exception $e){  
            DB::rollBack();

            Log::error('Error al crear usuario:', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }
    
    }

    public function Editar(Request $request){

        try{
            $request = $request->input('data');
            $request['Nombre'] = strtolower($request['Nombre']);
            DB::beginTransaction();

            $flujoEdit = Flujo::find($request['Id']);
            if(!$flujoEdit){
                throw new Exception('Flujo No Encontrado');
            }
            $flujoEdit->fill($request);
            $flujoEdit->save();

            foreach($request['ordenFlujo'] as $ordenFlujo ){
                $ordenEdit= OrdenFlujo::find($ordenFlujo['Id']);
                if(!$ordenEdit){
                    throw new Exception('Orden Flujo No Encontrado');
                }
                $ordenEdit->update([
                    'GrupoId'=> $ordenFlujo['GrupoId']
                ]);
            }
            DB::commit();

            $flujo = Flujo::select('flujo.Id', 'flujo.Nombre', 'flujo.Enabled','flujo.GrupoId','flujo.AreaId','area.Nombre as AreaNombre', 
                                    DB::raw('(SELECT CONCAT("[", GROUP_CONCAT(JSON_OBJECT(  "Nombre", estado_flujo.Nombre, 
                                                                                            "OrdenFlujoId", orden_flujo.Id,
                                                                                            "GrupoId", orden_flujo.GrupoId
                                                                                        )ORDER BY orden_flujo.Id), "]")
                                    FROM orden_flujo 
                                    JOIN estado_flujo ON estado_flujo.Id = orden_flujo.EstadoFlujoId 
                                    WHERE orden_flujo.FlujoId = flujo.Id) as Etapa')
                                )
                                ->where('flujo.Id','=',$request['Id'])
                                ->join('area', 'area.Id', '=', 'flujo.AreaId')
                                ->join('orden_flujo', 'orden_flujo.FlujoId', '=', 'flujo.Id')
                                ->groupBy('flujo.Id', 'flujo.Nombre', 'flujo.Enabled','flujo.GrupoId','flujo.AreaId','area.Nombre')
                                ->get();

            Log::info('Flujo Editado');
            return response()->json([
                'success' => true,
                'data' => $flujo,
                'message' => 'Flujo Editado'
            ],201);
        
        } catch(Exception $e){
            DB::rollBack();
            Log::error('Error al editar Flujo:', [$e->getMessage()]);
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
            Log::info('Flujo cambio de estado');
            return response()->json([
                'success' => true,
                'message' => 'Flujo cambio de estado'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al cambiar el estado del flujo', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
    
        }
    }
}
