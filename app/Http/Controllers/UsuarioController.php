<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Persona;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        $titulo= "Usuarios";
        $usuarios = Usuario::all();
        $centrocostos = CentroDeCosto::select('Id', 'Nombre')
                            ->where('Enabled','=', 1)
                            ->get();
        return view('usuario.usuario')->with([
                        'titulo'=> $titulo,
                        'usuarios'=> $usuarios,
                        'centrocostos'=> $centrocostos
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');
        $request['Username'] = strtolower($request['Username']);
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);
        $request['Rut'] = strtolower($request['Rut']);
        $request['Email'] = strtolower($request['Email']);
        
        try{
            $usuario = new Usuario();
            $usuario->validate($request);
            $usuario->fill($request);
            
            $persona = new Persona();
            $persona->validate($request);

            DB::beginTransaction();
            $usuario->save();
            $request['UsuarioId']= $usuario->Id;
            $persona->fill($request);
            $persona->save();          

            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Usuario y Persona Guardada'
            ],201);
        }catch(Exception $e){  
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);  
        }
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
