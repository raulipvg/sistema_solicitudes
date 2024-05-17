<?php

namespace App\Http\Controllers;

use App\Mail\Correo;
use App\Models\CentroDeCosto;
use App\Models\Compuesta;
use App\Models\ConsolidadoMe;
use App\Models\Flujo;
use App\Models\HistorialSolicitud;
use App\Models\Movimiento;
use App\Models\Solicitud;
use App\Models\Storage;
use App\Models\Persona;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


use Illuminate\Support\Facades\Mail;
use stdClass;

class SolicitudController extends Controller
{
    //
    public int $modulo =1;
    public function Index()
    {
        $user = auth()->user();
        // 12 Privilegios de Solicitudes
        $credenciales = [
                'verGrupos'=> $user->puedeVer(12),                
                'verTodas'=> $user->puedeRegistrar(12),
                'realizar'=> $user->puedeEditar(12),
                'aprobador'=> $user->puedeEliminar(12),
                'grupos'=> $user->gruposHabilidatos()
        ];

        $accesoLayout= $user->todoPuedeVer();
       
        if( $credenciales['realizar']){
            $movimientos = $user->movimientosPuedeVer();
                            
            /* $movimientos2 = Movimiento::select('Id','Nombre')
                                    ->where('Enabled',1)
                                    ->orderBy('Nombre','desc')
                                    ->get();
            
            $personas = Persona::select('Id','Rut',
                                DB::raw("CONCAT(UCASE(SUBSTRING(persona.Nombre, 1, 1)), LCASE(SUBSTRING(persona.Nombre FROM 2)), ' ', UCASE(SUBSTRING(persona.Apellido, 1, 1)), LCASE(SUBSTRING(persona.Apellido FROM 2))) AS NombreCompleto"),
                                'CentroCostoId')
                                ->where('Enabled',1)
                                ->orderBy('NombreCompleto','asc')
                                ->get();
            */
            $personas = $user->personasPuedeVer();

            $centrocostos = CentroDeCosto::select('centro_de_costo.Id', DB::raw("CONCAT(empresa.Nombre, ' - ', centro_de_costo.Nombre) AS Nombre"))
                                ->join('empresa','empresa.Id','=','centro_de_costo.EmpresaId')
                                ->where('centro_de_costo.Enabled','=', 1)
                                ->orderBy('Nombre','asc')
                                ->get();
        }else{
            $movimientos= null;
            $personas= null;
            $centrocostos = null;
        }
    
        $solicitudes= $this->solicitudesModo($credenciales,$user,"<");

        Log::info('Ingreso vista Solicitud');

        return view('solicitud.solicitud')->with([
            'movimientos'=> $movimientos,
            'personas' => $personas,
            'centrocostos'=> $centrocostos,
            'solicitudes'=> json_encode($solicitudes),
            'credenciales' => $credenciales,
            'accesoLayout' => $accesoLayout


        ]);
    }

    public function VerMovimientoAtributo(Request $request){  
        try{
            $request = $request->input('data');
            $movimientos = Movimiento::select('Id','Nombre')
                                    ->where('Enabled',1)
                                    ->orderBy('Nombre','desc')
                                    ->get();
            return response()->json([
                'success' => true,
                'movimientos' => $movimientos
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function RealizarSolicitud(Request $request){
        try{
            //VALIDACION DE ARCHIVOS
            $rule = [
                'file.*' =>[
                    'required',
                    'file',
                    'mimes:doc,docx,txt,jpg,jpeg,xls,xlsx,pdf',
                    'max:2048'
                ]
            ];

            $msg = [
                'file.*.required'=> 'Archivo Requerido',
                'file.*.mimes'=> 'Solo doc,docx,txt,jpg,jpeg,xls,xlsx,pdf',
                'file.*.max'=> 'Maximo 2MB',
                'file.*'=> 'Error en la carga de Archivos'
            ];
            $validator = Validator::make($request->all(), $rule, $msg);

            if ($validator->fails()) {
                // Si hay errores, redireccionar de vuelta con los mensajes de error
                throw new ValidationException($validator);
            }

            $file = $request->file('file');
            $request = json_decode($request->input('data'), true);
            $userId = auth()->user()->Id;
            //$url= $this->Upload($file);

            $request['solicitud']['UsuarioSolicitanteId'] = $userId;
            $request['solicitud']['ConsolidadoMesId'] = ConsolidadoMe::where('EstadoConsolidadoId','=', 1)->pluck('Id')->first();
            $solicitud = new Solicitud();
            $solicitud->validate($request['solicitud']);
            $solicitud->fill($request['solicitud']);
            
            DB::beginTransaction();
            $solicitud->save();

            $compuestas = [];
            /* Anterior
            foreach($request['compuesta'] as $compuesta){
                $obj = new Compuesta();
                $obj->MovimientoAtributoId = $compuesta['MovimientoAtributoId'];
                $obj->SolicitudId = $solicitud->Id;
                $obj->CostoReal = isset($compuesta['CostoReal'])?$compuesta['CostoReal']:null;
                $obj->TipoMonedaId = isset($compuesta['TipoMonedaId'])?$compuesta['TipoMonedaId']:null;
                $obj->Descripcion = isset($compuesta['Descripcion'])?$compuesta['Descripcion']:null;
                $obj->Cantidad = isset($compuesta['Cantidad'])?$compuesta['Cantidad']:null;
                $obj->Fecha1 = isset($compuesta['Fecha1'])?Carbon::createFromFormat('d-m-Y',$compuesta['Fecha1'])->format('Y-m-d'):null;
                $obj->Fecha2 = isset($compuesta['Fecha2'])?Carbon::createFromFormat('d-m-Y',$compuesta['Fecha2'])->format('Y-m-d'):null;

                $obj->validate([
                    'MovimientoAtributoId' => $obj->MovimientoAtributoId,
                    'CostoReal' => $obj->CostoReal,
                    'Descripcion' => $obj->Descripcion,
                    'SolicitudId' => $obj->SolicitudId,
                ]);
                $obj->save();
                

                //$compuestas[] = $obj;
            }
            */

            //Optimizada
            foreach($request['compuesta'] as $compuesta) {
                $compuestas[] = [
                    'MovimientoAtributoId' => $compuesta['MovimientoAtributoId'],
                    'SolicitudId' => $solicitud->Id,
                    'CostoReal' => $compuesta['CostoReal'] ?? 0,
                    'TipoMonedaId' => $compuesta['TipoMonedaId'] ?? 1,
                    'Descripcion' => $compuesta['Descripcion'] ?? null,
                    'Cantidad' => $compuesta['Cantidad'] ?? 1,
                    'Fecha1' => isset($compuesta['Fecha1']) ? Carbon::createFromFormat('d-m-Y', $compuesta['Fecha1'])->format('Y-m-d') : null,
                    'Fecha2' => isset($compuesta['Fecha2']) ? Carbon::createFromFormat('d-m-Y', $compuesta['Fecha2'])->format('Y-m-d') : null,
                ];
                // Agregar el objeto al arreglo de objetos a validar
                //$compuestas[] = $obj;
            }
            
            // Insertar todas las Compuestas en un lote
            Compuesta::insert($compuestas);
            unset($compuestas);
            $movExiste= Movimiento::find($request['movimiento']);
            if (!$movExiste) {
                throw new Exception('Movimiento no encontrado');
            }
            $flujo = $movExiste->flujo;
            if(!$flujo){
                throw new Exception('Flujo no encontrado');
            } 
            // Filtra la colección para obtener el orden_flujo con nivel 0.
            $ordenFlujoNivel0 = $flujo->orden_flujos->firstWhere('Nivel', 0);
            if(!$ordenFlujoNivel0){
                throw new Exception('Orden Flujo Nivel 0 no encontrado');
            }
            $estadoFlujoId = $ordenFlujoNivel0->estado_flujo->Id;
            $emails= $ordenFlujoNivel0->grupo->usuarios
                            ->where('Enabled', 1)
                            ->pluck('Email')
                            ->toArray();
    
            $historial = new HistorialSolicitud();
            $historial->EstadoFlujoId = $estadoFlujoId;
            $historial->EstadoEtapaFlujoId = 3; //Pendiente
            $historial->SolicitudId = $solicitud->Id;
            $historial->EstadoSolicitudId = 1; //INICIADO
            $historial->UsuarioId = $userId; 

            $historial->validate([
                'EstadoFlujoId' => $historial->EstadoFlujoId,
                'EstadoEtapaFlujoId' => $historial->EstadoEtapaFlujoId,
                'SolicitudId' => $historial->SolicitudId,
                'EstadoSolicitudId' => $historial->EstadoSolicitudId,
                'UsuarioId' => $historial->UsuarioId
            ]);

            $historial->save();
            unset($historial);
            unset($flujo);

            // Subir archivos a Google Cloud Storage
            if($file !=null){
                $urls = $this->Upload($file,$solicitud->Id);
                
                if(!$urls){throw new Exception('Error en cargar archivos');}
                
                $storage= [];
                foreach($urls as $url) {
                    $storage[] = [
                        'Url' => $url['URL'],
                        'Nombre' => $url['Nombre'],
                        'SolicitudId' => $solicitud->Id,
                    ];
                }            
                // Insertar todos los archivos en un lote
                Storage::insert($storage);
            }        
            DB::commit();
            Log::info('Solicitud generada #'.$solicitud->Id);

            //Obtener la solicitud con los datos actualizados
            $solicitud = Solicitud::getSolicitudesId($solicitud->Id);
            
            //Enviar Correo, Caso 1 - Nueva Solicitud
            $this->enviarCorreo($emails, $solicitud,1);
                           
            return response()->json([
                'success' => true,
                'data'=> $solicitud,
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al generar solicitud', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function Upload($files, $solicitudId){
        if ($files) {
            $result = [];
            // Crear un nombre de carpeta único
            $folderName = 'solicitud_'.$solicitudId.'_' . uniqid();
    
            foreach ($files as $file) {
                // Obtener el nombre original del archivo
                $fileName = $file->getClientOriginalName();
                // Construir la ruta del archivo con la carpeta
                $filePath = $folderName . '/' . $fileName;
    
                // Subir archivo a Google Cloud Storage
                $storage = new StorageClient([
                    'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                    'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE')
                ]);
    
                $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
                $bucket->upload(
                                fopen($file->getPathname(), 'r'),
                                ['name' => $filePath]
                                );    
                // Obtener la URL firmada para el archivo
                //$url = $object->signedUrl(new \DateTime('tomorrow'));
                // Agregar la URL al array de URLs
                 // Agregar el nombre del archivo y la URL al resultado
                $result[] = ['Nombre' => $fileName, 'URL' => $filePath];
            }
            return $result;
        } 
        return false;
    }

    public function Aprobar(Request $request){
        try{
            $request = $request->input('data');
            //$solicitudId= $request['a'];
            $historialId = $request['b'];
            $flujoId = $request['c'];

            ///BEGIN::VALIDACIONES
            $historialEdit= HistorialSolicitud::find($historialId);
            if (!$historialEdit) { throw new Exception('Historial no encontrado');}
            
            $semaforo = HistorialSolicitud::where('SolicitudId','=', $historialEdit->SolicitudId)
                                            ->where('Id','>', $historialEdit->Id )->exists();
            if ($semaforo){ throw new Exception('Etapa ya gestionada, recargue la pagina');}
            
            $flujoExiste = Flujo::find($flujoId);
            if (!$flujoExiste) { throw new Exception('Flujo no encontrado');}
     
            $estadoFlujoId= $historialEdit->EstadoFlujoId;
            $ordenFlujo = $flujoExiste->orden_flujos;
            $ordenFlujoEstadoExiste = $ordenFlujo->firstWhere('EstadoFlujoId', $estadoFlujoId);
            if (!$ordenFlujoEstadoExiste){ throw new Exception('No existe el estado en el flujo');}
            ///END:VALIDACIONES

            $userId = auth()->user()->Id;
            // SI ES UNA ETAPA DEL FLUJO INICIAL O INTERMEDIA
            DB::beginTransaction();
            $flag=true;
            if($ordenFlujoEstadoExiste->Pivot < 2){
                $ordenFlujoNext= $ordenFlujo->firstWhere('Nivel', $ordenFlujoEstadoExiste->Nivel+1);

                $historialEdit->update([
                    'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA
                    'UsuarioId'=> $userId 
                ]);
                
                $historial = new HistorialSolicitud();
                $historial->EstadoFlujoId = $ordenFlujoNext->estado_flujo->Id;
                $historial->EstadoEtapaFlujoId =3; //Pendiente
                $historial->SolicitudId = $historialEdit->SolicitudId;
                $historial->EstadoSolicitudId = 2; //En Curso
                $historial->save();
                $flag=true;

                $mensaje = 'Solicitud avanzó de etapa.';

                $emails= $ordenFlujoNext->grupo->usuarios
                            ->where('Enabled', 1)
                            ->pluck('Email')
                            ->toArray();
                $mov= $historialEdit->solicitud
                                    ->compuesta->first()
                                    ->movimiento_atributo
                                    ->movimiento->Nombre;

                //Obtener la solicitud con los datos actualizados para enviar correo
                //$solicitud = Solicitud::getSolicitudesId($historialEdit->SolicitudId);
                $solicitud = Solicitud::getSolicitudId_paraEnviarCorreo($historialEdit->SolicitudId);
                //Enviar Correo, Caso 2 - Solicitud Etapa Aprobada y en Curso (Solicitud EN CURSO)
                $this->enviarCorreo($emails, $solicitud,2);
               

            //SI ES UNA ETAPA FINAL DEL FLUJO
            }else{
                $historialEdit->update([
                    'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA,
                    'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                    'UsuarioId' => $userId 
                ]);
                $flag=false;
                $mensaje = 'Solicitud aprobada y terminada.';

                //Obtener la solicitud con los datos actualizados para enviar correo
                $solicitud = Solicitud::getSolicitudId_paraEnviarCorreo($historialEdit->SolicitudId);
                $movId = $solicitud->first()->MovimientoIdd;
                $NombreAprobador = Persona::where('persona.UsuarioId', $userId)
                                            ->selectRaw("CONCAT(persona.Nombre, ' ', persona.Apellido) as NombreCompleto")
                                            ->first()->NombreCompleto;
                $solicitud[0]->NombreAprobador = $NombreAprobador;
                //Condicion:: si es el Movimiento Pn - Solicitudes Pases Epi
                if(in_array($movId, [22,23,24])){                    
                    $emails = Movimiento::where('Id', $movId)
                                            ->pluck('Mail')
                                            ->toArray();
                                            
                    //VERIFICA SI EXISTEN MAILS EN EL MOVIMIENTO
                    if($emails[0] != null){
                        $emails = json_decode($emails[0],true);
                        //Enviar Correo, Caso 3 - Solicitud Terminada y Aprobada
                        $this->enviarCorreo($emails['mail'], $solicitud,3);
                    }
                }                
                //AGREGAR OTRAS CONDICIONES DE ENVIO DE CORREO SEGUN EL MOVIMIENTO ID

                
            }
            
            DB::commit(); 
            Log::info($mensaje);
            return response()->json([
                'success' => true,
                'data' => [
                    'flag'=> $flag, //Pivot <2 o no
                    'historialId'=> ($flag)? $historial->Id : null,
                    'estadoSolicitudId'=>($flag)? $historial->EstadoSolicitudId : null,
                    'flujoNombre' => ($flag)? $ordenFlujoNext->estado_flujo->Nombre : null,
                    'GrupoAprobadorId'=> ($flag)? $ordenFlujoNext->GrupoId : null
                ]
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error en el avance de la solicitud',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function AprobarSeleccion(Request $request){
        try{
            $request = $request->input('data');
            if( !(isset($request) && count($request['solicitudes']) > 0)){
                throw new Exception('Ninguna Solicitud Seleccionada');
            }
            $respuesta=[];
            foreach($request['solicitudes'] as $key => $solicitud){
                $historialId = $solicitud['b'];
                $flujoId = $solicitud['c'];

                ///BEGIN::VALIDACIONES
                $historialEdit= HistorialSolicitud::find($historialId);
                if (!$historialEdit) { continue;} //throw new Exception('Historial no encontrado');}
                    
                $semaforo = HistorialSolicitud::where('SolicitudId','=', $historialEdit->SolicitudId)
                                                ->where('Id','>', $historialEdit->Id )->exists();
                if ($semaforo){ continue;} //throw new Exception('Etapa ya gestionada, recargue la pagina');}
                    
                $flujoExiste = Flujo::find($flujoId);
                if (!$flujoExiste) { continue; }//throw new Exception('Flujo no encontrado');}
            
                $estadoFlujoId= $historialEdit->EstadoFlujoId;
                $ordenFlujo = $flujoExiste->orden_flujos;
                $ordenFlujoEstadoExiste = $ordenFlujo->firstWhere('EstadoFlujoId', $estadoFlujoId);
                if (!$ordenFlujoEstadoExiste){ continue; }//throw new Exception('No existe el estado en el flujo');}
                ///END:VALIDACIONES
                
                try{
                    $userId = auth()->user()->Id;
                    // SI ES UNA ETAPA DEL FLUJO INICIAL O INTERMEDIA
                    DB::beginTransaction();
                    $flag=true;
                    if($ordenFlujoEstadoExiste->Pivot < 2){
                        $ordenFlujoNext= $ordenFlujo->firstWhere('Nivel', $ordenFlujoEstadoExiste->Nivel+1);
        
                        $historialEdit->update([
                            'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA
                            'UsuarioId'=> $userId 
                        ]);
                        
                        $historial = new HistorialSolicitud();
                        $historial->EstadoFlujoId = $ordenFlujoNext->estado_flujo->Id;
                        $historial->EstadoEtapaFlujoId =3; //Pendiente
                        $historial->SolicitudId = $historialEdit->SolicitudId;
                        $historial->EstadoSolicitudId = 2; //En Curso
                        $historial->save();
                        $flag=true;
        
                        $mensaje = 'Solicitud #'.$historial->SolicitudId.' avanzó de etapa.';
        
                        $emails= $ordenFlujoNext->grupo->usuarios
                                    ->where('Enabled', 1)
                                    ->pluck('Email')
                                    ->toArray();

                        $mov= $historialEdit->solicitud
                                            ->compuesta->first()
                                            ->movimiento_atributo
                                            ->movimiento->Nombre;        
                    //SI ES UNA ETAPA FINAL DEL FLUJO
                    }else{
                        $historialEdit->update([
                            'EstadoEtapaFlujoId' => 1,  //ETAPA APROBADA,
                            'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                            'UsuarioId' => $userId 
                        ]);
                        $flag=false;
                        $mensaje = 'Solicitud #'.$historialEdit->SolicitudId.' aprobada y terminada.';
                    }                     
                    $respuesta []= [
                        'flag'=> $flag, //Pivot <2 o no
                        'historialId'=> $flag? $historial->Id : null,
                        'estadoSolicitudId'=>$flag? $historial->EstadoSolicitudId : null,
                        'flujoNombre' => $flag? $ordenFlujoNext->estado_flujo->Nombre : null,
                        'GrupoAprobadorId'=> $flag? $ordenFlujoNext->GrupoId : null,
                        'solicitudId'=> $flag? $historial->SolicitudId: $historialEdit->SolicitudId
                    ];
                    DB::commit();
                    Log::info($mensaje);
                }catch(Exception $e){
                    DB::rollback();
                    Log::error('Error en el avance de la solicitud',[$e->getMessage()]);
                    continue;
                }
            }           
            return response()->json([
                'success' => true,
                'data' => $respuesta
            ]);
        }catch(Exception $e){
            Log::error('Error en el avance de la solicitud',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }
    public function Rechazar(Request $request){
        try{
            $request = $request->input('data');
            //$solicitudId= $request['a'];
            $historialId = $request['b'];
            $flujoId = $request['c'];

            ///BEGIN::VALIDACIONES
            $historialEdit= HistorialSolicitud::find($historialId);
            if (!$historialEdit) { throw new Exception('Historial no encontrado');}
            $flujoExiste = Flujo::find($flujoId);
            if (!$flujoExiste) { throw new Exception('Flujo no encontrado');}

            $semaforo = HistorialSolicitud::where('SolicitudId','=', $historialEdit->SolicitudId)
                                        ->where('Id','>', $historialEdit->Id )->exists();
            if ($semaforo){ throw new Exception('Etapa ya gestionada, recargue la pagina');}

            $estadoFlujoId= $historialEdit->EstadoFlujoId;
            $ordenFlujo = $flujoExiste->orden_flujos;
            $ordenFlujoEstadoExiste = $ordenFlujo->firstWhere('EstadoFlujoId', $estadoFlujoId);
            if (!$ordenFlujoEstadoExiste){ throw new Exception('No existe el estado en el flujo');}
            ///END::VALIDACIONES
            
            $userId = auth()->user()->Id;

            DB::beginTransaction();
            $historialEdit->update([
                    'EstadoEtapaFlujoId' => 2,  //ETAPA Rechazada,
                    'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                    'UsuarioId' => $userId 
                ]);
        
            DB::commit();
            $mensaje = 'Solicitud #'.$historialEdit->SolicitudId.' rechazada y terminada.';
            Log::info($mensaje);
            return response()->json([
                'success' => true
            ]);
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al rechazar solicitud',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function RechazarSeleccion(Request $request){
    
        try{
            $request = $request->input('data');
            if( !(isset($request) && count($request['solicitudes']) > 0)){
                throw new Exception('Ninguna Solicitud Seleccionada');
            }
            $respuesta=[];
            foreach($request['solicitudes'] as $key => $solicitud){
                $historialId = $solicitud['b'];
                $flujoId = $solicitud['c'];

                ///BEGIN::VALIDACIONES
                $historialEdit= HistorialSolicitud::find($historialId);
                if (!$historialEdit){ continue;}
                $flujoExiste = Flujo::find($flujoId);
                if (!$flujoExiste) { continue;}

                $semaforo = HistorialSolicitud::where('SolicitudId','=', $historialEdit->SolicitudId)
                                            ->where('Id','>', $historialEdit->Id )->exists();
                if ($semaforo){ continue;}

                $estadoFlujoId= $historialEdit->EstadoFlujoId;
                $ordenFlujo = $flujoExiste->orden_flujos;
                $ordenFlujoEstadoExiste = $ordenFlujo->firstWhere('EstadoFlujoId', $estadoFlujoId);
                if (!$ordenFlujoEstadoExiste){ continue;}
                ///END::VALIDACIONES
                try{
                    $userId = auth()->user()->Id;

                    DB::beginTransaction();
                    $historialEdit->update([
                            'EstadoEtapaFlujoId' => 2,  //ETAPA Rechazada,
                            'EstadoSolicitudId' => 3, // SOLICITUD TERMINADA
                            'UsuarioId' => $userId 
                        ]);
                    $respuesta [] = [
                        'solicitudId'=> $historialEdit->SolicitudId,
                    ];
                    DB::commit();
                    $mensaje = 'Solicitud #'.$historialEdit->SolicitudId.' rechazada y terminada.';
                    Log::info($mensaje);
                }catch(Exception $e){
                    DB::rollBack();
                    Log::error('Error en rechazar la solicitud',[$e->getMessage()]);
                    continue;
                }
            }
            return response()->json([
                'success' => true,
                'data'=> $respuesta
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error('Error al rechazar solicitud',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }
    
    }
    public function VerTerminadas(){
        try{
            $user = auth()->user();
            // 12 Privilegios de Solicitudes
            $credenciales = [
                    'verGrupos'=> $user->puedeVer(12),                
                    'verTodas'=> $user->puedeRegistrar(12),
                    'realizar'=> $user->puedeEditar(12),
                    'aprobador'=> $user->puedeEliminar(12)
            ];

            $solicitudes= $this->solicitudesModo($credenciales,$user,"=");

            Log::info('Ingreso vista solicitudes terminadas');
        return response()->json([
                'success' => true,
                'solicitudes' => $solicitudes
            ]);
        }catch(Exception $e){
            Log::error('Error al ver solicitudes terminadas', [$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() 
            ]);
        }

    }

    public function VerActivas(){
        try{
            $user = auth()->user();
            // 12 Privilegios de Solicitudes
            $credenciales = [
                    'verGrupos'=> $user->puedeVer(12),                
                    'verTodas'=> $user->puedeRegistrar(12),
                    'realizar'=> $user->puedeEditar(12),
                    'aprobador'=> $user->puedeEliminar(12)
            ];

            $solicitudes= $this->solicitudesModo($credenciales,$user,"<");
            Log::info('Ingreso vista solicitudes activas');

            return response()->json([
                'success' => true,
                'solicitudes' => $solicitudes
            ]);

        }catch(Exception $e){
            Log::error('Error al ver solicitudes activas', [$e->getMessage()]);
            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()
            ]);
        }

    }

    public function solicitudesModo($credenciales,$user, $condicion){
        // SI variable condicional es < 3 Muestra Solicitudes activas
		// SI variable condicional es = 3 Muestra Solicitudes terminadas 
        if( !($credenciales['verGrupos'] || $credenciales['verTodas']) ){ //Modo 1, solo ver sus propias solicitudes
            $solicitudes = Solicitud::getSolicitudesListar(1,$condicion,$user->Id,0);
        }
        else if( $credenciales['verGrupos'] && !$credenciales['verTodas']){ //Modo 2, ver sus solicitudes y todas aquellas que en que su grupo participe
            $flujosParticipaGrupo = Flujo::select('flujo.Id as FlujoId')
                                        ->join('orden_flujo', 'orden_flujo.FlujoId', '=', 'flujo.Id')
                                        ->whereIn('orden_flujo.GrupoId', $user->grupos->where('pivot.Enabled', 1)->pluck('Id')->toArray())
                                        ->get();
            $solicitudes= Solicitud::getSolicitudesListar(2,$condicion,$user->Id, $flujosParticipaGrupo);
        }else if($credenciales['verTodas']){ //Modo 3, ver todas las solicitudes
            $solicitudes = Solicitud::getSolicitudesListar(3,$condicion,0,0);
        }
        return $solicitudes;
    }
   
    public function enviarCorreo($emails, $solicitud, $tipoMail){
        //$destinatario = 'raul.munoz@virginiogomez.cl';
        $solicitud = json_decode(json_encode($solicitud));
        if($tipoMail == 1){
            $solicitud[0]->Atributos = explode(",", $solicitud[0]->Atributos);
        }else{
            $solicitud[0]->Atributos = json_decode($solicitud[0]->Atributos);
        }
        try{
            Mail::to($emails)->send(new Correo($solicitud[0], $tipoMail));
        }catch(Exception $e){
            Log::info('Error Envio Email Solicitud #'.$solicitud[0]->Id);
        }
    }
}

