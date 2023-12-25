<?php

namespace App\Http\Controllers;

use App\Models\EstadoSolicitud;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;


class EstadoSolicitudController extends Controller
{
    public function Index()
    {
        $titulo = 'Estados de Solicitud';
        $estadosSolicitud = EstadoSolicitud::all();
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

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado de Solicitud Guardado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            
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

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Estado de Solicitud actualizado correctamente'
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
