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
                        ],
                        [
                            'Nivel' => 1,
                            [
                                'Id'=> 6,
                                'Nombre'=>'espera',
                            ],
                        ],
                        [
                            'Nivel' => 2,
                            [
                                'Id'=> 10,
                                'Nombre'=>'confirmacion',
                            ],
                        ],
                ],
                'historial' => [
                    [
                        'estadoFlujoId' => 2,
                        'tipo' => 1,
                        'usuario' => 'usuario 1',
                    ],
                    [
                        'estadoFlujoId' => 6,
                        'tipo' => 0, 
                        'usuario' => 'usuario 3',
                    ],
                ],
            ],
        ];
        $enCurso = [
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
                            
                        ],
                        [
                            'Nivel' => 1,
                            [
                                'Id'=> 6,
                                'Nombre'=>'espera',
                            ],
                        ],
                        [
                            'Nivel' => 2,
                            [
                                'Id'=> 10,
                                'Nombre'=>'confirmacion',
                            ],
                        ],
                ],
                'historial' => [
                    [
                        'estadoFlujoId' => 2,
                        'tipo' => 1,
                        'usuario' => 'usuario 1',
                    ],
                    [
                        'estadoFlujoId' => 6,
                        'tipo' => 2,
                        'usuario' => '-',
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
                        ],
                        [
                            'Nivel' => 1,
                            [
                                'Id'=> 6,
                                'Nombre'=>'espera',
                            ],
                        ],
                        [
                            'Nivel' => 2,
                            [
                                'Id'=> 10,
                                'Nombre'=>'confirmacion',
                            ],
                        ],
                ],
                'historial' => [
                    [
                        'estadoFlujoId' => 2,
                        'tipo' => 2,
                        'usuario' => '-'
                    ],
                ],
            ],
        ];
        $respuestas = [
            $iniciada,
            $enCurso,
            $rechazada
        ];

        return response()->json($respuestas[$request['solicitudId']]);
    }
}
