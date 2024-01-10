<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    //
    public function Index(){

        $movimientos = Movimiento::select('Id','Nombre')
                                ->where('Enabled',1)
                                ->orderBy('Nombre','desc')
                                ->get();
        return view('solicitud.solicitud')->with(['movimientos'=> $movimientos]);
    }
}
