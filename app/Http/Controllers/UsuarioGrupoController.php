<?php

namespace App\Http\Controllers;

use App\Models\UsuarioGrupo;
use Exception;
use Illuminate\Http\Request;

class UsuarioGrupoController extends Controller
{
    public function Index()
    {
        return View('usuariogrupo.usuariogrupo');
    }
    public function Ver(Request $request)
    {
        $usuarioGrupo = $request->input('data');

        try{
            $usuarioGrupo= UsuarioGrupo::find($request);

            return response()->json([
                'success' => true,
                'data' => $usuarioGrupo 
            ],200);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function VerGrupo(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'data' => 1,
            'message' => 'Modelo recibido y procesado']);
    }
    public function Registrar(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'data' => 1,
            'message' => 'Modelo recibido y procesado']);
    }
    public function Eliminar(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'data' => 1,
            'message' => 'Modelo recibido y procesado']);
    }

}
