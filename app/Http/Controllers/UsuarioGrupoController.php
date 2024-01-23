<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Usuario;
use App\Models\UsuarioGrupo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsuarioGrupoController extends Controller
{
    public function Index()
    {
        return View('usuariogrupo.usuariogrupo');
    }
    public function Ver(Request $request)
    {
        $usuarioId = $request->input('data');

        try{
            $usuarioExiste= Usuario::find($usuarioId);
            if (!$usuarioExiste) {
                throw new Exception('Usuario no encontrado');
            }
            $usuarioGrupo = UsuarioGrupo::select('usuario_grupo.Id','grupo.Nombre','usuario_grupo.created_at', 'usuario_grupo.Enabled')
                                        ->join('grupo','grupo.Id','=','usuario_grupo.GrupoId')
                                        ->where('usuario_grupo.UsuarioId', $usuarioId)
                                        ->where('usuario_grupo.Enabled', 1)
                                        ->get();

            return response()->json([
                'success' => true,
                'data' => $usuarioGrupo,
                'usuario'=> $usuarioExiste->Id 
            ],200);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function VerGrupo(Request $request)
    {
        $request = $request->input('data');

        $usuarioExiste = Usuario::find($request);
        if (!$usuarioExiste) {
            throw new Exception('Usuario no encontrado');
        }
        $gruposAsociados = UsuarioGrupo::select('GrupoId')
                                ->where('UsuarioId', $request)
                                ->where('Enabled',1)
                                ->pluck('GrupoId') // Utiliza pluck para obtener solo los valores de 'Id'
                                ->toArray();

        $gruposNoAsociados = Grupo::select('Id', 'Nombre')
                                    ->where('Enabled', 1)
                                    ->whereNotIn('Id', $gruposAsociados)
                                    ->get();
        
        return response()->json([
            'success' => true,
            'data' => $gruposNoAsociados,
            'nombre' => $usuarioExiste->persona->Nombre.' '.$usuarioExiste->persona->Apellido, 
            'message' => 'Modelo recibido y procesado'],200);
    }
    public function Registrar(Request $request)
    {
        $request = $request->input('data');
        $request['Enabled'] =1;
        try{
            $acceso = new UsuarioGrupo();
            $acceso->validate($request);
            $acceso->fill($request);
            
            DB::beginTransaction();

            $acceso->save();

            DB::commit();
            Log::info('Usuario #'. $request['UsuarioId'].' asignado al grupo #'.$request['GrupoId']);
            return response()->json([
                'success' => true,
                'data'=> [
                    'Nombre'=> $acceso->grupo->Nombre,
                    'Id'=> $acceso->Id,
                    'created_at'=> $acceso->grupo->created_at,
                ],
                'message' => 'Nuevo Acceso Guardado'
            ]);
        }catch(Exception $e){  
            DB::rollBack();
            Log::info('Error al asignar usuario #'. $request['UsuarioId'].' al grupo #'.$request['GrupoId']);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }
    }
    public function Eliminar(Request $request)
    {
        $request = $request->input('data');
        

        try{
            $accesoExiste = UsuarioGrupo::find($request);

            if (!$accesoExiste) {
                throw new Exception('Acceso al Grupo no encontrado');
            }
            DB::beginTransaction();
            $accesoExiste->update([
                   'Enabled' => ($accesoExiste['Enabled'] == 1)? 0: 1 
            ]);
            $accesoExiste->save();
            DB::commit();
            Log::info('Eliminando '.$request);
            
            return response()->json([
                'success' => true,
                'message' => 'Acceso al Grupo cambiado'
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al eliminar'.$request);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
