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

    public function VerCC(Request $request){
        
        try{
                $centrocostos = CentroDeCosto::select('Id', 'Nombre')
                                ->where('Enabled','=', 1)
                                ->get();

                return response()->json([
                                        'success' => true,
                                        'option' => $centrocostos,
                                        'message' => 'CC Entregado'
                                    ],200);
             }catch(Exception $e){
                return response()->json([
                                    'success' => false,
                                    'message' => $e->getMessage()
                                ],400);  
        }
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

        try{
            $usuario= Usuario::Select('usuario.Id','usuario.Username','usuario.Email','usuario.Enabled',
                                   'persona.Nombre','persona.Apellido','persona.Rut','centro_de_costo.Nombre as NombreCC','persona.CentroCostoId')
                                   ->where('usuario.Id', $request)
                                   ->join('persona','persona.UsuarioId','=','usuario.Id')
                                   ->join('centro_de_costo','centro_de_costo.Id','=','persona.CentroCostoId')
                                   ->first();


            if (!$usuario) {
                throw new Exception('Usuario no encontrada');
            }

            $cc = CentroDeCosto::select('Id', 'Nombre', 'Enabled')
                                ->where('Enabled', 1)
                                ->orWhere('Id', $usuario->CentroCostoId)
                                ->get();


            return response()->json([
                'success' => true,
                'data' => $usuario,
                'option' => $cc   
            ],200);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function Editar(Request $request)
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

            DB::beginTransaction();

            $usuarioEdit = Usuario::find($request['Id']);
            if (!$usuarioEdit) {
                throw new Exception('Persona no encontrada');
            }
            //$userEdit->Username
            $usuarioEdit->fill($request);
            $usuarioEdit->save();

            $personaEdit = Persona::where( 'UsuarioId', $request['Id'])->first();
            if (!$personaEdit) {
                throw new Exception('Persona no encontrada');
            }
            $persona= new Persona();
            $request['Id']= $personaEdit->Id;
            $persona->validate($request);

            $personaEdit->fill($request);
            $personaEdit->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Persona actualizada correctamente'
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
     * Update the specified resource in storage.
     */
    public function CambiarEstado(Request $request)
    {
        $request = $request->input('data');
        
        try{
            $usuarioEdit = Usuario::find($request);

            if (!$usuarioEdit) {
                throw new Exception('Usuario no encontrado');
            }
            DB::beginTransaction();
            $usuarioEdit->update([
                   'Enabled' => ($usuarioEdit['Enabled'] == 1)? 0: 1 
            ]);
            $usuarioEdit->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado de la Usuario cambiado'
            ],201);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
        }
    }


}
