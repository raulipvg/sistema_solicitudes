<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    public function Index()
    {
        $titulo= "Empresas";

        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        // 3 Privilegios de Empresa
        $credenciales['Empresa'] = [
            'puedeVer'=> $user->can('ver-empresa'),
            'puedeRegistrar'=> $user->can('registrar-empresa'),
            'puedeEditar'=> $user->can('editar-empresa'),
            'puedeEliminar'=> $user->can('eliminar-empresa'),
        ];
        // 4 Privilegios Centro de Costo
        $credenciales['CC'] = [
            'puedeVer'=> $user->can('ver-cc'),
            'puedeRegistrar'=> $user->can('registrar-cc'),
            'puedeEditar'=> $user->can('editar-cc'),
            'puedeEliminar'=> $user->can('eliminar-cc'),
        ];
        $accesoLayout= $user->todoPuedeVer();
        //END::PRIVILEGIOS

        $empresas = Empresa::select(
                                'empresa.Id',
                                'empresa.Nombre',
                                'empresa.Rut',
                                'empresa.Email',
                                'empresa.Enabled'
                            )->get();
        Log::info('Ingreso vista empresa');

        return view('empresa.empresa')->with([
                        'titulo'=> $titulo,
                        'empresas'=> $empresas,
                        'credenciales' => $credenciales,
                        'accesoLayout' => $accesoLayout                        
                    ]);
    
    }
      /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Rut'] = strtolower($request['Rut']);
        
        try{
            $empresa = new Empresa();
            $empresa->validate($request);
            $empresa->fill($request);
            
            DB::beginTransaction();

            $empresa->save();
            Log::info('Nueva empresa');
            DB::commit(); 
            return response()->json([
                'success' => true,
                'empresa'=> [[
                    'Id'=> $empresa->Id,
                    'Nombre'=> $empresa->Nombre,
                    'Rut'=> $empresa->Rut,
                    'Email'=> $empresa->Email,
                    'Enabled'=> $empresa->Enabled,
                ]],
                'message' => 'Empresa Guardada'
            ],201);
        }catch(Exception $e){  
            DB::rollBack();
            Log::error('Error al Guardar Empresa', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);  
        }

    }

    public function VerId(Request $request)
    {
        $request = $request->input('data');

        try{
            $empresa= Empresa::find($request);

            if (!$empresa) {
                throw new Exception('Empresa no encontrada');
            }
            Log::info('Ver empresa');
            return response()->json([
                'success' => true,
                'data' => $empresa 
            ]);

        }catch(Exception $e){
            Log::error('Error al ver empresa',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function Editar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Rut'] = strtolower($request['Rut']);
        $request['Email'] = strtolower($request['Email']);

        try{
            $empresa = new Empresa();
            $empresa->validate($request);

            DB::beginTransaction();

            $empresaEdit = Empresa::find($request['Id']);
            if (!$empresaEdit) {
                throw new Exception('Empresa no encontrada');
            }
            //$userEdit->Username
            $empresaEdit->fill($request);
            $empresaEdit->save();

            DB::commit();
            Log::info('Modificar empresa');
            return response()->json([
                'success' => true,
                'empresa'=> [[
                    'Id'=> $empresaEdit->Id,
                    'Nombre'=> $empresaEdit->Nombre,
                    'Rut'=> $empresaEdit->Rut,
                    'Email'=> $empresaEdit->Email,
                    'Enabled'=> $empresaEdit->Enabled,
                ]],
                'message' => 'Empresa actualizada correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar empresa',[$e->getMessage()]);
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
            $empresaEdit = Empresa::find($request);

            if (!$empresaEdit) {
                throw new Exception('Empresa no encontrada');
            }
            DB::beginTransaction();
            $empresaEdit->update([
                   'Enabled' => ($empresaEdit['Enabled'] == 1)? 0: 1 
            ]);
            $empresaEdit->save();
            DB::commit();
            Log::info('Cambio de estado de empresa');
            return response()->json([
                'success' => true,
                'message' => 'Estado de la Empresa cambiado'
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar estado de empresa',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function VerCentroCosto(Request $request)
    {

        $request = $request->input('data');

        try{

            $empresaExiste = Empresa::find($request);
            if (!$empresaExiste) {
                throw new Exception('Empresa no encontrada');
            }

            $centrocosto= CentroDeCosto::select('Nombre', 'Id', 'created_at', 'Enabled')
                                        ->where('EmpresaId',$request) 
                                        ->where('Enabled', '=', 1)
                                        ->get();
            

            return response()->json([
                'success' => true,
                'data' => $centrocosto,
                'empresa' => $empresaExiste->Id 
            ]);

        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
