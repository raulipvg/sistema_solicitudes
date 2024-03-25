<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Grupo;
use App\Models\GrupoMovimiento;
use App\Models\GrupoPrivilegio;
use App\Models\GrupoSolicitud;
use App\Models\Movimiento;
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

        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        // 2 Privilegios de Grupo
        $credenciales['Grupo'] = [
            'puedeVer'=> $user->can('ver-grupo'),
            'puedeRegistrar'=> $user->can('registrar-grupo'),
            'puedeEditar'=> $user->can('editar-grupo'),
            'puedeEliminar'=> $user->can('eliminar-grupo'),
        ];
        $accesoLayout= $user->todoPuedeVer();
        //END::PRIVILEGIOS

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
            'credenciales' => $credenciales,
            'accesoLayout' => $accesoLayout 
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
            Log::info('Nuevo grupo');
            return response()->json([
                'success' => true,
                'message' => 'Area Guardada'
            ],200);

        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al guardar grupo', [$e->getMessage()]);
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
                return View('error.error404');
            }

             //BEGIN::PRIVILEGIOS
            $user = auth()->user();
            // 2 Privilegios de Grupo
            $credenciales['Grupo'] = [
                'puedeVer'=> $user->can('ver-grupo'),
                'puedeRegistrar'=> $user->can('registrar-grupo'),
                'puedeEditar'=> $user->can('editar-grupo'),
                'puedeEliminar'=> $user->can('eliminar-grupo'),
            ];
            // 1 Privilegios de Usuario
            $credenciales['Usuario'] = [
                'puedeVer'=> $user->can('ver-usuario'),
                'puedeRegistrar'=> $user->can('registrar-usuario'),
                'puedeEditar'=> $user->can('editar-usuario'),
                'puedeEliminar'=> $user->can('eliminar-usuario'),
            ];
            $accesoLayout= $user->todoPuedeVer();
            //END::PRIVILEGIOS

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
                'credenciales' => $credenciales,
                'accesoLayout' => $accesoLayout 
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
            //Inicio::Movimientos Autorizados
            $movimientos = Movimiento::select('Id','Nombre')->where('Enabled','=', 1)->orderBy('Nombre','asc')->get();
            $gruposMovimientos=GrupoMovimiento::select('MovimientoId')->where('GrupoId','=',$request)->pluck('MovimientoId')->toArray();
            //Fin::Movimientos Autorizados

            $grupos= Grupo::select('Id','Nombre')->where('Enabled','=',1)->orderBy('Nombre','asc')->get();
            $gruposAutorizados = GrupoSolicitud::select('GrupoAccedidoId')->where('GrupoAutorizadoId','=',$request)->pluck('GrupoAccedidoId')->toArray();

            Log::info('Ver información del grupo');
            return response()->json([
                'success' => true,
                'data' => $grupo,
                'movimientos'=> $movimientos,
                'gruposmovimientos'=> $gruposMovimientos,
                'grupos'=> $grupos,
                'gruposaut'=> $gruposAutorizados
            ]);
        }catch(Exception $e){
            Log::error('Error al ver grupo',[$e->getMessage()]);
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
            }

            //INICO::SECCION DE EDICION DE ACCESO A MOVIMIENTOS
            // Eliminar los grupos de movimientos existentes para el grupo actual
            GrupoMovimiento::where('GrupoId', $grupoEdit->Id)->delete();
            if (isset($request['GrupoMovimiento'])) {
                $grupoMovimientos = collect($request['GrupoMovimiento'])
                                    ->map(function ($movimientoId) use ($grupoEdit) {
                                        return [
                                            'GrupoId' => $grupoEdit->Id,
                                            'MovimientoId' => $movimientoId
                                        ];
                                    });            
                GrupoMovimiento::insert($grupoMovimientos->all());
            }
            //FIN::SECCION DE EDICION DE ACCESO A MOVIMIENTOS

            //INICO::SECCION DE EDICION DE ACCESO A REALIZAR A GRUPOS UNA SOLICITUD 
            GrupoSolicitud::where('GrupoAutorizadoId', $grupoEdit->Id)->delete();            
            if (isset($request['GrupoAut'])) {
                $grupoSolicitudes = collect($request['GrupoAut'])
                                    ->map(function ($grupoAccedidoId) use ($grupoEdit) {
                                            return [
                                                'GrupoAutorizadoId' => $grupoEdit->Id,
                                                'GrupoAccedidoId' => $grupoAccedidoId
                                            ];
                                    });            
                GrupoSolicitud::insert($grupoSolicitudes->all());
            }
            //FIN::SECCION DE EDICION DE ACCESO A REALIZAR A GRUPOS UNA SOLICITUD 
            DB::commit();
            Log::info('Privilegios del grupo actualizados');
            return response()->json([
                'success' => true,
                'message' => 'Grupo actualizado correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar privilegios de grupo', [$e->getMessage()]);
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
            Log::info('Cambio de estado de grupo');
            return response()->json([
                'success' => true,
                'message' => 'Estado del Grupo cambiado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar grupo',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
}
