<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        $titulo= "Usuarios";
        return view('usuario.usuario')->with([
                        'titulo'=> $titulo
                    ]);
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
