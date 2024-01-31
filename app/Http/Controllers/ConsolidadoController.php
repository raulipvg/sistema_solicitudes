<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Movimiento;

class ConsolidadoController extends Controller
{
    public function Index (Request $request){
        $titulo= "Consolidado de solicitudes";
        //$usuarios = Usuario::all();

        //BEGIN::PRIVILEGIOS
        $user = auth()->user();
        $accesoLayout= $user->todoPuedeVer();

        $movimientos = Movimiento::select('Id','Nombre','Enabled')->get();
        $empresas = Empresa::select('Id','Nombre','Enabled')->get();

        $centrocostos = CentroDeCosto::select('Id','Nombre','Enabled')->get(); 

        return view('consolidado.consolidado')->with([
            'accesoLayout'=>$accesoLayout,
            'titulo' => $titulo,
            'movimientos' => $movimientos,
            'empresas'=> $empresas,
            'centrocostos'=> $centrocostos,
        ]);
    }

    public function getConsolidados(Request $request){

    }
}
