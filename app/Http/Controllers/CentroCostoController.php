<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
    public function Guardar(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }

    public function CambiarEstado(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }
}
