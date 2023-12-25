<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Grupo;
use App\Models\Usuario;
use App\Models\UsuarioGrupo;
use Doctrine\DBAL\Schema\View;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
{
    public function Index()
    {
        $titulo="Grupos";

        //Contar Usuarios con Acceso al Grupo, que estén Habilitados para el grupo y
        // Que el estado del usuario sea activo
        $datosgrupo = Grupo::withCount([
            'usuarios' => function ($query) {
            $query->where('usuario_grupo.Enabled', 1);
        }])->get();

        return View('grupo.grupo')->with([
            'titulo'=> $titulo,
            'datosgrupo'=> $datosgrupo,
            'flag'=> 2, //significa que es para la vista /grupo/
        ]);
    }
    public function Guardar(Request $request)
    {
        $request = $request->input('data');
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Descripcion'] = strtolower($request['Descripcion']);

        try{
            $grupo = new Grupo();
            $grupo->validate($request);
            $grupo->fill($request);
            
            DB::beginTransaction();

            $grupo->save(); 

            DB::commit(); 
            
            return response()->json([
                'success' => true,
                'message' => 'Area Guardada'
            ],200);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function Ver($id){
        
        try{
            $datosgrupo= Grupo::find($id); 
            if (!$datosgrupo) {
                return View('blank');
            }
            $centrocostos = CentroDeCosto::select('Id', 'Nombre')
                            ->where('Enabled','=', 1)
                            ->get();
                            
            $grupo = Grupo::find($id);
            $titulo= 'Ver Grupo '.$grupo->Nombre;
            if (!$grupo) {
                // Manejo de error si el Grupo no se encuentra
                // Puedes lanzar una excepción, redirigir, o realizar alguna otra acción según tu lógica
            }
        
            $usuarios = $grupo->usuarios;

            return View('grupo.vergrupo')->with([
                'titulo'=> $titulo,
                'datosgrupo'=> $datosgrupo,
                'usuarios'=> $usuarios,
                'centrocostos'=> $centrocostos,
                'flag' => 1 //significa que es para la vista /grupo/ver
            ]);
        }catch(Exception $e){
        
        }
    }

    
}
