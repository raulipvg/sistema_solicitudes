<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Persona;
use App\Models\Usuario;
use Exception;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function Index()
    {
        $titulo= "Personas";
        //$personas = Persona::all();
        $personas = Persona::select('persona.Id',
                                    DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"),
                                    'persona.Rut','centro_de_costo.Nombre AS NombreCC',
                                    'empresa.Nombre as NombreEmpresa','persona.Enabled','persona.UsuarioId')
                                    ->join('centro_de_costo','centro_de_costo.Id','=','persona.CentroCostoId')
                                    ->join('empresa','empresa.Id','=','centro_de_costo.EmpresaId')
                                    ->get();

        

        $centrocostos = CentroDeCosto::select('centro_de_costo.Id', DB::raw("CONCAT(empresa.Nombre, ' - ', centro_de_costo.Nombre) AS Nombre"))
                            ->join('empresa','empresa.Id','=','centro_de_costo.EmpresaId')
                            ->where('centro_de_costo.Enabled','=', 1)
                            ->get();    

        return view('persona.persona')->with([
                        'titulo'=> $titulo,
                        'personas'=> $personas,
                        'centrocostos'=> $centrocostos
                    ]);
    
    }
      /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);
        
        try{
            $persona = new Persona();
            $persona->validate($request);
            $persona->fill($request);
            
            DB::beginTransaction();

            $persona->save();

            DB::commit(); 
            return response()->json([
                'success' => true,
                'persona' => [[
                    'Id'=> $persona->Id,
                    'NombreCompleto'=> $persona->Nombre.' '.$persona->Apellido,
                    'Rut' => $persona->Rut,
                    'Enabled' => $persona->Enabled,
                    'NombreEmpresa'=> $persona->centro_de_costo->empresa->Nombre,
                    'NombreCC'=> $persona->centro_de_costo->Nombre,

                ]],
                'message' => 'Persona Guardada'
            ],201);
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
        //NO MUESTRA EL SELECT2 SI TIENE CC DESHABILITADO
        $request = $request->input('data');       
        try{
            $persona= Persona::find($request);

            if (!$persona) {
                throw new Exception('Persona no encontrada');
            }

            $cc = CentroDeCosto::select('centro_de_costo.Id', 'centro_de_costo.Nombre as Centro', 'empresa.Nombre as Empresa')
                                ->join('empresa','empresa.Id','=','centro_de_costo.EmpresaId')
                                ->where('centro_de_costo.Enabled','=', 1)
                                ->orWhere('centro_de_costo.Id', $persona->CentroCostoId)
                                ->get();


            return response()->json([
                'success' => true,
                'data' => $persona,
                'option' => $cc 
            ],200);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
        }
    }

    public function Editar(Request $request)
    {
        $request = $request->input('data');
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);
        try{
            $persona = new Persona();
            $persona->validate($request);

            DB::beginTransaction();

            $personaEdit = Persona::find($request['Id']);
            if (!$personaEdit) {
                throw new Exception('Persona no encontrada');
            }
            //$userEdit->Username
            $personaEdit->fill($request);
            $personaEdit->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'persona' => [[
                    'Id'=> $personaEdit->Id,
                    'NombreCompleto'=> $personaEdit->Nombre.' '.$personaEdit->Apellido,
                    'Rut' => $personaEdit->Rut,
                    'Enabled' => $personaEdit->Enabled,
                    'NombreEmpresa'=> $personaEdit->centro_de_costo->empresa->Nombre,
                    'NombreCC'=> $personaEdit->centro_de_costo->Nombre,

                ]],
                'message' => 'Persona actualizada correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function CambiarEstado(Request $request)
    {
        $request = $request->input('data');
        
        try{
            $personaEdit = Persona::find($request);

            if (!$personaEdit) {
                throw new Exception('Persona no encontrada');
            }
            DB::beginTransaction();
            $personaEdit->update([
                   'Enabled' => ($personaEdit['Enabled'] == 1)? 0: 1 
            ]);
            $personaEdit->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado de la Persona cambiado'
            ]);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function DarAcceso(Request $request)
    {
        //FALTA LO DE ENCRIPTAR PASSWORD
        $request = $request->input('data');
        
        $request['Username'] = strtolower($request['Username']);
        $request['Email'] = strtolower($request['Email']);
        
        try{
            $usuario = new Usuario();
            $usuario->validate($request);
            $usuario->fill($request);
            
            DB::beginTransaction();

            $usuario->save();

            $personaEdit = Persona::find($request['PersonaId']);
            if (!$personaEdit) {
                throw new Exception('Persona no encontrada');
            }
            $personaEdit->update([
                'UsuarioId' => $usuario->Id
            ]);
            $personaEdit->save();

            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Usuario Registrado'
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
