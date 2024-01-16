<?php

namespace App\Http\Controllers;

use App\Models\HistorialSolicitud;
use App\Models\OrdenFlujo;
use App\Models\Flujo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EstadoFlujoSolicitudControllerTest extends Controller
{
    public function GetData(Request $request){
        $request = $request->input('data');
        /*
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
 */
        $flujo = OrdenFlujo::select('orden_flujo.Nivel',
                                    'estado_flujo.Nombre',
                                    'estado_flujo.Id')
                            ->where('orden_flujo.FlujoId','=',$request['flujoId'])
                            ->join('estado_flujo','estado_flujo.Id','=','orden_flujo.EstadoFlujoId')
                            ->get();
        $historial = HistorialSolicitud::select('EstadoFlujoId',
                                                'estado_etapa.Id as estadoEtapa',
                                                'estado_etapa.Nombre as estadoEtapaNombre',
                                                'usuario.Username as usuario')
                                        ->where('historial_solicitud.Id','=',$request['historialId'])
                                        ->join('usuario','usuario.Id', '=','historial_solicitud.UsuarioId')
                                        ->join('estado_etapa','estado_etapa.Id','=','historial_solicitud.EstadoEtapaFlujoId')
                                        ->get();
        $flujoNombre = Flujo::find($request['flujoId'])->first()->Nombre;
        return response()->json([
            'success' => true,
            'data' => [
                'historial' => $historial,
                'ordenFlujos' => $flujo,
                'nombreFlujo' => $flujoNombre
            ]
        ]);
    }

    public function getHistorial(Request $request){
        $request = $request->input('data');

        $ordenFlujo = OrdenFlujo::select('orden_flujo.Nivel', 
                                            'estado_flujo.Nombre as EstadoNombre',
                                            'estado_flujo.Id as EstadoId'
                                        )
                    ->where('orden_flujo.FlujoId','=',$request['flujoId'])
                    ->join('estado_flujo','estado_flujo.Id','=','orden_flujo.EstadoFlujoId')
                    ->get();
        

        $historial = HistorialSolicitud::select('historial_solicitud.created_at as creacion', 
                                                'historial_solicitud.updated_at as actualizacion',
                                                'historial_solicitud.EstadoFlujoId as estadoFlujoId',
                                                'historial_solicitud.EstadoEtapaFlujoId',
                                                DB::raw('CONCAT(persona.Nombre, " ", persona.Apellido) as Usuario'),
                                                'historial_solicitud.EstadoSolicitudId')
                                        ->join('persona','persona.UsuarioId','=','historial_solicitud.UsuarioId')
                                        ->where('historial_solicitud.SolicitudId','=',$request['solicitudId'])
                                        ->get();

/*
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
        ];*/
        return response()->json([
            'success'=> true,
            'data' => [
                'ordenFlujos' => $ordenFlujo,
                'historial' => $historial
            ]
        ]);
    }
}
