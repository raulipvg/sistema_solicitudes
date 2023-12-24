<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function Index()
    {
        
        $titulo= "Empresa";
        $empresas= Empresa::all();
        return view('empresa.empresa')->with([
                        'titulo'=> $titulo,
                        'empresas'=> $empresas                        
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

            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Empresa Guardada'
            ]);
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
        $request = $request->input('data');

        try{
            $empresa= Empresa::find($request);

            if (!$empresa) {
                throw new Exception('Empresa no encontrada');
            }

            return response()->json([
                'success' => true,
                'data' => $empresa 
            ]);

        }catch(Exception $e){

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
            return response()->json([
                'success' => true,
                'message' => 'Empresa actualizada correctamente'
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
            
            return response()->json([
                'success' => true,
                'message' => 'Estado de la Empresa cambiado'
            ]);

        }catch(Exception $e){
            DB::rollBack();
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
