<?php

namespace App\Http\Controllers;

use App\Models\EstadoSolicitud;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EstadoSolicitudController extends Controller
{
    public function Index()
    {
        $titulo = 'Estados de Solicitud';
        $estadosSolicitud = EstadoSolicitud::select('Id','Nombre','Enabled')->get();

        return View('estadosolicitud.estadosolicitud')->with([
            'titulo'=>$titulo,
            'estadosSolicitud'=>$estadosSolicitud
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
            $estadoSolicitud = new EstadoSolicitud();
            $estadoSolicitud->validate($request);
            $estadoSolicitud->fill($request);

            DB::beginTransaction();
            $estadoSolicitud->save();

            Log::info('Nuevo estado de solicitud: '.$estadoSolicitud->Id);
            DB::commit();
            return response()->json([
                'success' => true,
                'estadosSolicitud'=>[[
                    'Id'=> $estadoSolicitud->Id,
                    'Nombre'=> $estadoSolicitud->Nombre,
                    'Enabled' => $estadoSolicitud->Enabled
                ]],                
                'message' => 'Estado de Solicitud Guardado'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al crear un nuevo estado: '.$estadoSolicitud->Nombre, [$e]);
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
            $estadoSolicitud = EstadoSolicitud::find($request);

            if(!$estadoSolicitud){
                throw new Exception ('Estado de solicitud no encontrado');
            }

            return response()->json([
                'success' => true,
                'data' => $estadoSolicitud
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
            $estadoSolicitud = new EstadoSolicitud();
            $estadoSolicitud->validate($request);

            DB::beginTransaction();

            $estadoSolicitudEdit = EstadoSolicitud::find($request['Id']);
            
            if(!$estadoSolicitudEdit){
                throw new Exception('Estado de Solicitud no encontrado');
            }
            $estadoSolicitudEdit->fill($request);
            $estadoSolicitudEdit->save();
            Log::info('Se modificó el estado Id: '.$estadoSolicitudEdit->Id);
            DB::commit();
            return response()->json([
                'success' => true,
                'estadosSolicitud'=>[[
                    'Id'=> $estadoSolicitudEdit->Id,
                    'Nombre'=> $estadoSolicitudEdit->Nombre,
                    'Enabled' => $estadoSolicitudEdit->Enabled
                ]], 
                'message' => 'Estado de Solicitud actualizado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar estado:'.$estadoSolicitudEdit->Id, [$e]);
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
            $estadoSolicitudEdit = EstadoSolicitud::find($request);

            if(!$estadoSolicitudEdit){
                throw new Exception('Estado de Solicitud no encontrado');
            }
            DB::beginTransaction();

            $estadoSolicitudEdit->update([
                'Enabled' => ($estadoSolicitudEdit['Enabled'] == 1)? 0 : 1
            ]);

            $estadoSolicitudEdit->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado del Estado de Solicitud cambiado'
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
