<?php

namespace App\Http\Controllers;

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

        return view('consolidado.consolidado')->with([
            'accesoLayout'=>$accesoLayout,
            'titulo' => $titulo,
            'movimientos' => $movimientos
        ]);
    }

    public function getConsolidados(Request $request){

    }
}
