<?php

namespace App\Http\Controllers;

use App\Models\EstadoFlujo;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EstadoFlujoController extends Controller
{
    public function Index()
    {
        $titulo = 'Estados de Flujo';

        $user = auth()->user();
        // 8 Privilegios de Estado Flujo
        $credenciales = [
                'puedeVer'=> $user->puedeVer(8),
                'puedeRegistrar'=> $user->puedeRegistrar(8),
                'puedeEditar'=> $user->puedeEditar(8),
                'puedeEliminar'=> $user->puedeEliminar(8),
        ];

        $estadosFlujo = EstadoFlujo::select('Id','Nombre','Enabled')->get();

        return View('estadoflujo.estadoflujo')->with([
            'titulo'=>$titulo,
            'estadosFlujo'=>$estadosFlujo,
            'credenciales'=>$credenciales
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
            $estadoFlujo = new EstadoFlujo();
            $estadoFlujo->validate($request);
            $estadoFlujo->fill($request);

            DB::beginTransaction();
            $estadoFlujo->save();

            Log::info('Nuevo estado de flujo: '.$estadoFlujo->Id);
            DB::commit();
            return response()->json([
                'success' => true,
                'estadosFlujo'=>[[
                    'Id'=> $estadoFlujo->Id,
                    'Nombre'=> $estadoFlujo->Nombre,
                    'Enabled' => $estadoFlujo->Enabled
                ]],                
                'message' => 'Estado de Flujo Guardado'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al crear un nuevo estado: '.$estadoFlujo->Nombre, [$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]); 
        }
        
    }

    public function VerId(Request $request)
    {
        $request = $request->input('data');

        try{
            $estadoFlujo = EstadoFlujo::find($request);

            if(!$estadoFlujo){
                throw new Exception ('Estado de flujo no encontrado');
            }

            return response()->json([
                'success' => true,
                'data' => $estadoFlujo
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
            $estadoFlujo = new EstadoFlujo();
            $estadoFlujo->validate($request);

            DB::beginTransaction();

            $estadoFlujoEdit = EstadoFlujo::find($request['Id']);
            
            if(!$estadoFlujoEdit){
                throw new Exception('Estado de Flujo no encontrado');
            }
            $estadoFlujoEdit->fill($request);
            $estadoFlujoEdit->save();
            Log::info('Se modificó el estado Id: '.$estadoFlujoEdit->Id);
            DB::commit();
            return response()->json([
                'success' => true,
                'estadosFlujo'=>[[
                    'Id'=> $estadoFlujoEdit->Id,
                    'Nombre'=> $estadoFlujoEdit->Nombre,
                    'Enabled' => $estadoFlujoEdit->Enabled
                ]], 
                'message' => 'Estado de Flujo actualizado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar estado:'.$estadoFlujoEdit->Id, [$e]);
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
            $estadoFlujoEdit = EstadoFlujo::find($request);

            if(!$estadoFlujoEdit){
                throw new Exception('Estado de Flujo no encontrado');
            }
            DB::beginTransaction();

            $estadoFlujoEdit->update([
                'Enabled' => ($estadoFlujoEdit['Enabled'] == 1)? 0 : 1
            ]);

            $estadoFlujoEdit->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado del Estado de Flujo cambiado'
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
