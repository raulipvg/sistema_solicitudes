<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function Index()
    {
        return View('movimiento.movimiento');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function VerId(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'data' => 1,
            'message' => 'Modelo recibido y procesado']);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function Editar(Request $request)
    {
        $request = $request->input('data');
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function CambiarEstado(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }
}
