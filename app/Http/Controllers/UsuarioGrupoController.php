<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioGrupoController extends Controller
{
    public function Index()
    {
        return View('usuariogrupo.usuariogrupo');
    }
    public function Ver(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'data' => 1,
            'message' => 'Modelo recibido y procesado']);
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
