<?php

namespace App\Http\Controllers;

use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function Index()
    {
        $titulo="Grupos";

        $privilegios = ['Privilegio 1', 'Privilegio 2', 'Privilegio 3', 'Privilegio 4', 'Privilegio 5'];

        $datosgrupo = [];

        for ($i = 1; $i <= 5; $i++) {
            $nombreGrupo = 'Grupo ' . $i;
            $privilegiosGrupo = [];
            // Asignar al menos 4 privilegios al grupo
            for ($j = 0; $j < 4; $j++) {
                $privilegiosGrupo[] = ['Nombre' => $privilegios[rand(0, 4)]];
            }
        
            $datosgrupo[] = [
                'Nombre' => $nombreGrupo,
                'Privilegios' => $privilegiosGrupo,
                'flag' => 2  //significa que es para la vista /grupo
            ];
        }
        //$datosgrupo['flag']= 2; //significa que es para la vista /grupo
        // Convertir el objeto $datosgrupo a JSON y luego decodificarlo nuevamente como objeto
        $datosgrupo = json_decode(json_encode($datosgrupo), false);


        return View('grupo.grupo')->with([
            'titulo'=> $titulo,
            'datosgrupo'=> $datosgrupo
        ]);
    }

    public function Ver(Request $request){
        $titulo= 'Ver Grupo Administrador';

        $datosgrupo['Nombre']= 'Administrador';
        $datosgrupo['Privilegios']= [
            ['Nombre' => 'Privilegio 1'],
            ['Nombre' => 'Privilegio 2'],
            ['Nombre' => 'Privilegio 3'],
            ['Nombre' => 'Privilegio 4'],
            ['Nombre' => 'Privilegio 5'],
        ];
        $datosgrupo['flag']= 1; //significa que es para la vista /grupo/ver

        // Convertir el objeto $datosgrupo a JSON y luego decodificarlo nuevamente como objeto
        $datosgrupo = json_decode(json_encode($datosgrupo), false);

        return View('grupo.vergrupo')->with([
            'titulo'=> $titulo,
            'datosgrupo'=> $datosgrupo
        ]);
    }

    
}
