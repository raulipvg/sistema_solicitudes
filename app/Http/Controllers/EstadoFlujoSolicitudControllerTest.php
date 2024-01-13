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
                        'usuario' => 'usuario 3',
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

    public function getHistorial(Request $request){
        $request = $request->input('data');

        $rechazada = [
            'solicitud' => [
                'id' => '11',
                'solicitante' => 'Nombre Apellido',
                'receptor' => 'Nombre Apellido',
                'costoSolicitud' => '50000',
                'centroCosto' => 'centro de costos de finanzas',
                'movimiento' => 'Movimiento 1',
                'atributos' => ['atributo 1','atributo 3','atributo 3',],
            ],'flujo' => [
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
                    'creacion' => '2024-01-04 13:32:52',
                    'actualizacion' => '2024-01-05 14:32:52',
                    'estadoFlujoId' => 2,
                    'tipo' => 1,
                    'usuario' => 'usuario 1',
                ],
                [
                    'creacion' => '2024-01-05 14:32:52',
                    'actualizacion' => '2024-01-05 17:32:52',
                    'estadoFlujoId' => 6,
                    'tipo' => 0,
                    'usuario' => 'usuario 3',
                ],
            ],
        ];
        $iniciada =[
            'solicitud' => [
                'id' => '11',
                'solicitante' => 'Nombre Apellido',
                'receptor' => 'Nombre Apellido',
                'costoSolicitud' => '50000',
                'centroCosto' => 'centro de costos de finanzas',
                'movimiento' => 'Movimiento 1',
                'atributos' => ['atributo 1','atributo 3','atributo 3',],
            ],
            'flujo' => [
                'Id'=>'5',
                'Nombre'=>'flujouno'
            ],
            'ordenFlujos' => [
                    [
                        'Nivel' => 0,
                            'Id'=> 2,
                            'Nombre'=>'en tramite',
                    ],
                    [
                        'Nivel' => 1,
                            'Id'=> 6,
                            'Nombre'=>'espera',
                    ],
                    [
                        'Nivel' => 2,
                            'Id'=> 10,
                            'Nombre'=>'confirmacion',
                    ],
            ],
            'historial' => [
                [
                    'creacion' => '2024-01-04 13:32:52',
                    'actualizacion' => '2024-01-04 13:32:52',
                    'estadoFlujoId' => 2,
                    'tipo' => 2,
                    'usuario' => 'usuario 1',
                ],
            ],
        ];
        $enCurso= [
            'solicitud' => [
                'id' => '11',
                'solicitante' => 'Nombre Apellido',
                'receptor' => 'Nombre Apellido',
                'costoSolicitud' => '50000',
                'centroCosto' => 'centro de costos de finanzas',
                'movimiento' => 'Movimiento 1',
                'atributos' => ['atributo 1','atributo 3','atributo 3',],
            ],
            'flujo' => [
                'Id'=>'5',
                'Nombre'=>'flujouno'
            ],
            'ordenFlujos' => [
                    [
                        'Nivel' => 0,
                            'Id'=> 2,
                            'Nombre'=>'en tramite',
                    ],
                    [
                        'Nivel' => 1,
                            'Id'=> 6,
                            'Nombre'=>'espera',
                    ],
                    [
                        'Nivel' => 2,
                            'Id'=> 10,
                            'Nombre'=>'confirmacion',
                    ],
            ],
            'historial' => [
                [
                    'creacion' => '2024-01-04 13:32:52',
                    'actualizacion' => '2024-01-04 14:32:52',
                    'estadoFlujoId' => 2,
                    'tipo' => 1,
                    'usuario' => 'usuario 1',
                ],
                [
                    'creacion' => '2024-01-05 13:32:52',
                    'actualizacion' => '2024-01-05 15:32:52',
                    'estadoFlujoId' => 2,
                    'tipo' => 1,
                    'usuario' => 'usuario 1',
                ],
            ],
            'estadoSolicitud' => 2,
        ];

        $respuestas = [
            $iniciada,
            $enCurso,
            $rechazada
        ];
        return response()->json([
            'success'=> true,
            'data' => $respuestas[$request['solicitudId']]
        ]);
    }
}
