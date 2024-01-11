<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadoFlujoSolicitudControllerTest extends Controller
{
    public function GetData(Request $request){
        $request = $request->input('data');
        $rechazada = 
        [
            'success' => true,
            'data' => [
                'flujo' => [
                    'Id'=>'5',
                    'Nombre'=>'flujouno'
                ],
                'ordenFlujos' => [
                        [
                            'Nivel' => 0,
                            [
                                'Id'=> 2,
                                'Nombre'=>'en tramite',
                            ],
                            'Grupo' => 'grupo 1',
                        ],
                        [
                            'Nivel' => 1,
                            [
                                'Id'=> 6,
                                'Nombre'=>'espera',
                            ],
                            'Grupo' => 'grupo 3',
                        ],
                        [
                            'Nivel' => 2,
                            [
                                'Id'=> 10,
                                'Nombre'=>'confirmacion',
                            ],
                            'Grupo' => 'administrador',
                        ],
                ],
                'historial' => [
                    [
                        'estadoFlujoId' => 2,
                        'tipo' => 1
                    ],
                    [
                        'estadoFlujoId' => 6,
                        'tipo' => 0
                    ],
                ],
            ],
        ];
        $aprobada = [
            'success' => true,
            'data' => [
                'flujo' => [
                    'Id'=>'5',
                    'Nombre'=>'flujouno'
                ],
                'ordenFlujos' => [
                        [
                            'Nivel' => 0,
                            [
                                'Id'=> 2,
                                'Nombre'=>'en tramite',
                            ],
                            'Grupo' => 'grupo 1',
                        ],
                        [
                            'Nivel' => 1,
                            [
                                'Id'=> 6,
                                'Nombre'=>'espera',
                            ],
                            'Grupo' => 'grupo 3',
                        ],
                        [
                            'Nivel' => 2,
                            [
                                'Id'=> 10,
                                'Nombre'=>'confirmacion',
                            ],
                            'Grupo' => 'administrador',
                        ],
                ],
                'historial' => [
                    [
                        'estadoFlujoId' => 2,
                        'tipo' => 1
                    ],
                    [
                        'estadoFlujoId' => 6,
                        'tipo' => 2
                    ],
                ],
            ],
        ];
        $iniciada = [
            'success' => true,
            'data' => [
                'flujo' => [
                    'Id'=>'5',
                    'Nombre'=>'flujouno'
                ],
                'ordenFlujos' => [
                        [
                            'Nivel' => 0,
                            [
                                'Id'=> 2,
                                'Nombre'=>'en tramite',
                            ],
                            'Grupo' => 'grupo 1',
                        ],
                        [
                            'Nivel' => 1,
                            [
                                'Id'=> 6,
                                'Nombre'=>'espera',
                            ],
                            'Grupo' => 'grupo 3',
                        ],
                        [
                            'Nivel' => 2,
                            [
                                'Id'=> 10,
                                'Nombre'=>'confirmacion',
                            ],
                            'Grupo' => 'administrador',
                        ],
                ],
                'historial' => [
                    [
                        'estadoFlujoId' => 2,
                        'tipo' => 1
                    ],
                    [
                        'estadoFlujoId' => 6,
                        'tipo' => 2
                    ],
                ],
            ],
        ];
        $respuestas = [
            $aprobada,
            $rechazada
        ];

        return response()->json($respuestas[$request['solicitudId']]);
    }
}
