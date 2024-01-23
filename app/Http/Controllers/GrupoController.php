<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Grupo;
use App\Models\GrupoPrivilegio;
use App\Models\Privilegio;
use App\Models\Usuario;
use App\Models\UsuarioGrupo;
use Doctrine\DBAL\Schema\View;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GrupoController extends Controller
{
    public function Index()
    {
        $titulo="Grupos";

        //Contar Usuarios con Acceso al Grupo, que estén Habilitados para el grupo y
        // Que el estado del usuario sea activo
        $user = auth()->user();
        // 2 Privilegios de Grupo
        $credencialesGrupo = [
                'puedeVer'=> $user->puedeVer(2),
                'puedeRegistrar'=> $user->puedeRegistrar(2),
                'puedeEditar'=> $user->puedeEditar(2),
                'puedeEliminar'=> $user->puedeEliminar(2),
        ];

        $datosgrupo = Grupo::withCount([
            'usuarios' => function ($query) {
            $query->where('usuario.Enabled', 1);
        }])->get();

        $privilegios = Privilegio::select('Id','Nombre')
                                        ->where('Enabled','=',1)
                                        ->get();
        Log::info('Acceso vista Grupo');
        return View('grupo.grupo')->with([
            'titulo'=> $titulo,
            'datosgrupo'=> $datosgrupo,
            'privilegios'=> $privilegios,
            'flag'=> 2, //significa que es para la vista /grupo/
            'credencialesGrupo' => $credencialesGrupo
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

           // $privilegios = Privilegio::select('Id','Nombre')->where('Enabled','=',1)->get();

           /*
            foreach ($privilegios as $privilegio) {
                $grupoprivilegio = new GrupoPrivilegio();
                $grupoprivilegio->GrupoId = $grupo->Id;
                $grupoprivilegio->PrivilegioId = $privilegio->Id;
                $grupoprivilegio->save();
            }
            */

            DB::commit(); 
            Log::info('Nuevo grupo #'. $grupo->Id);
            return response()->json([
                'success' => true,
                'message' => 'Area Guardada'
            ],200);

        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al guardar grupo', [$e]);
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
            $user = auth()->user();
            // 2 Privilegios de Grupo
            $credencialesGrupo = [
                    'puedeVer'=> $user->puedeVer(2),
                    'puedeRegistrar'=> $user->puedeRegistrar(2),
                    'puedeEditar'=> $user->puedeEditar(2),
                    'puedeEliminar'=> $user->puedeEliminar(2),
            ];

            // 1 Privilegios de Grupo
            $credencialesUsuario = [
                    'puedeVer'=> $user->puedeVer(1),
                    'puedeRegistrar'=> $user->puedeRegistrar(1),
                    'puedeEditar'=> $user->puedeEditar(1),
                    'puedeEliminar'=> $user->puedeEliminar(1),
            ];
            $centrocostos = CentroDeCosto::select('Id', 'Nombre')
                            ->where('Enabled','=', 1)
                            ->get();
                            
            $grupo = Grupo::select('Id','Nombre')
                            ->where('Id','=',$id)
                            ->first();

            $privilegios = Privilegio::select('Id','Nombre')
                            ->where('Enabled','=',1)
                            ->get();

            $titulo= 'Ver Grupo '.$grupo->Nombre;
            if (!$grupo) {
                // Manejo de error si el Grupo no se encuentra
                // Puedes lanzar una excepción, redirigir, o realizar alguna otra acción según tu lógica
            }
        
            $usuarios = Usuario::select('usuario.Id',
                                        'usuario.Username',
                                        'usuario.Email',
                                        'usuario.Enabled',
                                        DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"))
                                ->join('usuario_grupo','usuario_grupo.UsuarioId','=','usuario.Id')
                                ->join('persona', 'persona.UsuarioId', '=', 'usuario.Id')
                                ->where('usuario_grupo.Enabled','=', 1)
                                ->where('usuario_grupo.GrupoId','=', $grupo->Id)
                                ->distinct()
                                ->get();
            


            return View('grupo.vergrupo')->with([
                'titulo'=> $titulo,
                'datosgrupo'=> $datosgrupo,
                'privilegios'=> $privilegios,
                'usuarios'=> $usuarios,
                'centrocostos'=> $centrocostos,
                'flag' => 1, //significa que es para la vista /grupo/ver
                'credencialesGrupo' => $credencialesGrupo,
                'credencialesUsuario'=> $credencialesUsuario,
            ]);
        }catch(Exception $e){
        
        }
    }

    public function VerEdit(Request $request){
        $request = $request->input('data');

        try{
            $grupo = Grupo::with(['privilegios' => function ($query) {
                                $query->select('privilegio.Id', 'privilegio.Nombre')
                                        ->withPivot('Ver', 'Registrar', 'Editar', 'Eliminar')
                                        ->orderBy('privilegio.Id','asc');
                            }])
                            ->select('grupo.Id', 'grupo.Nombre')
                            ->find($request);

            if (!$grupo) {
                throw new Exception('Grupo no encontrado');
            }

            $privilegios = Privilegio::select('Id','Nombre')
                                        ->where('Enabled','=',1)
                                        ->get();

            Log::info('Ver información del grupo #'.$request);
            return response()->json([
                'success' => true,
                'data' => $grupo
            ]);
        }catch(Exception $e){
            Log::error('Error al ver grupo #'.$request,[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function EditarGrupoPrivilegio(Request $request){
        $request = $request->input('data');
        $request['Nombre'] = strtolower($request['Nombre']);
        try{
            $grupo = new Grupo();
            $grupo->validate($request);

            DB::beginTransaction();

            $grupoEdit = Grupo::find($request['Id']);
            if (!$grupoEdit) {
                throw new Exception('Grupo no encontrado');
            }
            //$userEdit->Username
            $grupoEdit->fill($request);
            $grupoEdit->save();

            foreach($request['GrupoPrivilegio'] as $grupoPrivilegio ){
               
                GrupoPrivilegio::updateOrCreate(
                    ['Id' => $grupoPrivilegio['Id']], // Busca por el ID proporcionado
                    [
                        'Ver' => isset($grupoPrivilegio['Ver']) ? 1 : 0,
                        'Registrar' => isset($grupoPrivilegio['Registrar']) ? 1 : 0,
                        'Editar' => isset($grupoPrivilegio['Editar']) ? 1 : 0,
                        'Eliminar' => isset($grupoPrivilegio['Eliminar']) ? 1 : 0,
                        'GrupoId'=> $grupoEdit->Id,
                        'PrivilegioId' => $grupoPrivilegio['PrivilegioId']
                    ]
                );
               /* $grupoPrivilegioEdit = GrupoPrivilegio::find($grupoPrivilegio['Id']);
                if (!$grupoPrivilegioEdit) {
                    continue; // Opcional: Puede lanzar una excepción si se espera un GrupoPrivilegio específico.
                }     
                $grupoPrivilegioEdit->update([
                    'Ver' => (isset($grupoPrivilegio['Ver']))?1:0,
                    'Registrar' => (isset($grupoPrivilegio['Registrar']))?1:0,
                    'Editar' => (isset($grupoPrivilegio['Editar']))?1:0,
                    'Eliminar' => (isset($grupoPrivilegio['Eliminar']))?1:0
                ]);*/
                //$grupoPrivilegioEdit->save();                 
            }

            DB::commit();
            Log::info('Privilegios del grupo #'.$request['Id'].' actualizados');
            return response()->json([
                'success' => true,
                'message' => 'Grupo actualizado correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar privilegios de grupo #'.$request['Id'], [$e]);
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
            $grupoEdit = Grupo::find($request);

            if (!$grupoEdit) {
                throw new Exception('Grupo no encontrado');
            }
            DB::beginTransaction();
            $grupoEdit->update([
                   'Enabled' => ($grupoEdit['Enabled'] == 1)? 0: 1 
            ]);
            $grupoEdit->save();
            DB::commit();
            Log::info('Cambio de estado de grupo #'.$request);
            return response()->json([
                'success' => true,
                'message' => 'Estado del Grupo cambiado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar grupo #'.$request,[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
}
