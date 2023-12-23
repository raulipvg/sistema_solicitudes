<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlujoController extends Controller
{
    public function Eliminar(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }
}
