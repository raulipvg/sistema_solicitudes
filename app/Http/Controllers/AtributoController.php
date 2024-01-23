<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atributo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AtributoController extends Controller
{
    public function Index()
    {
        $titulo = 'Atributo';
        //$atributos = Atributo::all();

        $atributos = Atributo::select('Id','Nombre','ValorReferencia','Enabled')->get();

        Log::info('');
        return View('atributo.atributo')->with([
            'titulo'=>$titulo,
            'atributos' => $atributos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Guardar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);
        
        try{
            $atributo = new Atributo();
            $atributo->validate($request);
            $atributo->fill($request);

            DB::beginTransaction();
            $atributo->save();

            DB::commit();
            Log::info('Nuevo atributo #'.$atributo->Id);
            return response()->json([
                'success' => true,
                'atributo'=>[[
                    'Id'=> $atributo->Id,
                    'Nombre'=>$atributo->Nombre,
                    'ValorReferencia'=>$atributo->ValorReferencia,
                    'Enabled'=>$atributo->Enabled
                ]],
                'message' => 'Atributo guardado'
            ], 200);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al guardar atributo.',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]); 
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function VerId(Request $request)
    {
        $request = $request->input('data');

        try{
            $atributo = Atributo::find($request);

            if(!$atributo) {
                throw new Exception('Atributo no encontrado');
            }

            
            Log::info('Ver información de atributo #'.$request);
            return response()->json([
                'success' => true,
                'data' => $atributo
            ]);
        }catch(Exception $e){
            Log::error('Error al ver atributo #'.$request,[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function Editar(Request $request)
    {
        $request = $request->input('data');

        $request['Nombre'] = strtolower($request['Nombre']);
        
        try{
            $atributo = new Atributo();
            $atributo->validate($request);

            DB::beginTransaction();

            $atributoEdit = Atributo::find($request['Id']);

            if(!$atributoEdit){
                throw new Exception('Atributo no encontrado');
            }

            $atributoEdit->fill($request);
            $atributoEdit->save();

            DB::commit();
            Log::info('Se modificó el atributo #'.$request['Id']);
            return response()->json([
                'success' => true,
                'atributo'=>[[
                    'Id'=> $atributoEdit->Id,
                    'Nombre'=>$atributoEdit->Nombre,
                    'ValorReferencia'=>$atributoEdit->ValorReferencia,
                    'Enabled'=>$atributoEdit->Enabled
                ]],
                'message' => 'Atributo actualizado correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar atributo #'.$request['Id'],[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function CambiarEstado(Request $request)
    {
        $request = $request->input('data');

        try{
            $atributoEdit = Atributo::find($request);

            if(!$atributoEdit){
                throw new Exception('Atributo no encontrado');
            }

            DB::beginTransaction();

            $atributoEdit->update([
                   'Enabled' => ($atributoEdit['Enabled'] == 1)? 0: 1 
            ]);
            $atributoEdit->save();
            DB::commit();
            Log::info('Cambio de estado de atributo #'.$request);
            return response()->json([
                'success' => true,
                'message' => 'Estado del Atributo cambiado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar atributo #'.$request,[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
