<?php

namespace App\Http\Controllers;

use App\Models\AtributoTipo;
use App\Models\ConfigAtributo;
use Illuminate\Http\Request;
use App\Models\Atributo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Else_;

class AtributoController extends Controller
{
    public function Index()
    {
        $titulo = 'Atributo';
        //$atributos = Atributo::all();

        $atributos = Atributo::select('Id','Nombre','ValorReferencia','TipoMoneda','Enabled')
                    ->join('tipomoneda','tipomoneda.Id', '=', 'TipoMonedaId')
                    ->get();

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
            DB::beginTransaction();

            $atributo = new Atributo();
            $atributo->validate($request);
            $atributo->fill($request);         
            $atributo->save();

            /*
            foreach($request['AtributoTipo'] as $key => $value){
                $atributoTipo = new AtributoTipo();
                $atributoTipo->AtributoId = $atributo->Id;
                $atributoTipo->TipoId = $value['TipoId'];
                $atributoTipo->save();
            }
            */
            $atributoTipos = [];
            $date = now();
            foreach ($request['AtributoTipo'] as $key => $value) {
                $atributoTipos[] = [
                    'AtributoId' => $atributo->Id,
                    'TipoId' => $value['TipoId'],
                    'created_at' => $date, 
                    'updated_at' => $date,
                ];
            }

            // Realizar la inserción masiva
            AtributoTipo::insert($atributoTipos);

            DB::commit();
            Log::info('Nuevo atributo');
            return response()->json([
                'success' => true,
                'atributo'=>[[
                    'Id'=> $atributo->Id,
                    'Nombre'=>$atributo->Nombre,
                    'Simbolo' =>$atributo->tipoMoneda->Simbolo,
                    'ValorReferencia'=>$atributo->ValorReferencia,
                    'Enabled'=>$atributo->Enabled
                ]],
                'message' => 'Atributo guardado'
            ], 200);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al guardar atributo.',[$e->getMessage()]);
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
            $atributo = Atributo::select('atributo.Id',
                                        'atributo.Nombre', 
                                        'atributo.ValorReferencia',
                                        'atributo.TipoMonedaId',
                                        'atributo.Descripcion',
                                        'atributo.Enabled',
                                        DB::raw('CONCAT("[", GROUP_CONCAT(JSON_OBJECT(
                                                                            "Id", atributo_tipo.Id, 
                                                                            "TipoId", atributo_tipo.TipoId
                                                                        )), "]") as atributoTipo')
                                    )
                                    ->leftJoin('atributo_tipo','atributo_tipo.AtributoId','=','atributo.Id')
                                    ->where('atributo.Id','=', $request)
                                    ->groupBy('atributo.Id','atributo.Nombre','atributo.ValorReferencia',
                                                'atributo.Descripcion','atributo.TipoMonedaId','atributo.Enabled')
                                    ->first();
            
            if(!$atributo) {
                throw new Exception('Atributo no encontrado');
            }        
            Log::info('Ver información de atributo');
            return response()->json([
                'success' => true,
                'data' => $atributo
            ]);
        }catch(Exception $e){
            Log::error('Error al ver atributo',[$e]);
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
            $atributoEdit = Atributo::find($request['Id']);
            if(!$atributoEdit){
                throw new Exception('Atributo no encontrado');
            }     
            $atributo->validate($request);           
            $atributoEdit->fill($request);     

            AtributoTipo::where('AtributoId', $atributoEdit->Id)->delete();
            $date = now();
            foreach ($request['AtributoTipo'] as $key => $value) {
                AtributoTipo::Create([
                        'TipoId'=> $value['TipoId'],                        
                        'AtributoId'=> $atributoEdit->Id,
                        'updated_at'=> $date,
                        ]
                    
                );
            }

            DB::beginTransaction();
            $atributoEdit->save();
           // $atributoEdit->configuracion->save();

            DB::commit();
            Log::info('Se modificó el atributo');
            return response()->json([
                'success' => true,
                'atributo'=>[[
                    'Id'=> $atributoEdit->Id,
                    'Nombre'=>$atributoEdit->Nombre,
                    'Simbolo' =>$atributoEdit->TipoMoneda->Simbolo,
                    'ValorReferencia'=>$atributoEdit->ValorReferencia,
                    'Enabled'=>$atributoEdit->Enabled
                ]],
                'message' => 'Atributo actualizado correctamente'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar atributo',[$e->getMessage()]);
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
            Log::info('Cambio de estado de atributo');
            return response()->json([
                'success' => true,
                'message' => 'Estado del Atributo cambiado'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al modificar atributo',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
