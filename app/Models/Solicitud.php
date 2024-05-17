<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Solicitud
 * 
 * @property int $Id
 * @property int $CostoSolicitud
 * @property int $PersonaId
 * @property int $CentroCostoId
 * @property int $ConsolidadoMesId
 * @property int $UsuarioSolicitanteId
 * @property int $TipoMonedaId
 * 
 * @property CentroDeCosto $centro_de_costo
 * @property ConsolidadoMe $consolidado_me
 * @property Persona $persona
 * @property Collection|Compuesta[] $compuesta
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 *
 * @package App\Models
 */
class Solicitud extends Model
{
	protected $table = 'solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'CostoSolicitud' => 'int',
		'PersonaId' => 'int',
		'CentroCostoId' => 'int',
		'ConsolidadoMesId' => 'int',
		'FechaDesde'=> 'date',
		'FechaHasta'=> 'date',
		'UsuarioSolicitanteId'=> 'int',
		'TipoMonedaId' => 'int',
	];

	protected $fillable = [
		'PersonaId',
		'CentroCostoId',
		'CostoSolicitud',
		'FechaDesde',
		'FechaHasta',
		'UsuarioSolicitanteId',
		'ConsolidadoMesId'		
	];
	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}
	public function centro_de_costo()
	{
		return $this->belongsTo(CentroDeCosto::class, 'CentroCostoId');
	}

	public function consolidado_me()
	{
		return $this->belongsTo(ConsolidadoMe::class, 'ConsolidadoMesId');
	}

	public function usuario_solicitante()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioSolicitanteId');
	}
	public function compuesta()
	{
		return $this->hasMany(Compuesta::class, 'SolicitudId');
	}

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'SolicitudId');
	}

	public function validate(array $data){
		$id = isset($data['Id']) ? $data['Id'] : null;

		$rules = [
			'PersonaId' => 'required|numeric',
			'CentroCostoId' => 'required|numeric',
			'CostoSolicitud' => 'required|numeric',
			'FechaDesde' => 'nullable|date',
			'FechaHasta' => 'nullable|date',
		];

		$messages = [
            '*' => 'Hubo un problema con el campo :attribute.'
            // Agrega más mensajes personalizados aquí según tus necesidades
		];

		$validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $databaseErrors = $errors->getMessages();

            foreach ($databaseErrors as $fieldErrors) {
                foreach ($fieldErrors as $fieldError) {
                    if (strpos($fieldError, 'database') !== false) {
                        //Problema de BD
                        $messages['*'] = 'Error';
                        break 2; // Salir de los bucles si se encuentra un error de la base de datos
                    }
                }
            }
            throw new ValidationException($validator);
        }
	}

	public static function querySolicitudes(){
		
		$solicitudes= Solicitud::select('solicitud.Id',DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"), 'persona.Rut as RUT',
																	'centro_de_costo.Nombre as CentroCosto',
																	'solicitud.created_at as FechaCreado','historial_solicitud.EstadoSolicitudId',
																	'estado_flujo.Nombre as EstadoFlujo', 'movimiento.Nombre as Movimiento', 'movimiento.Id as MovimientoIdd',
																	'flujo.Nombre as NombreFlujo','flujo.Id as FlujoIdd','orden_flujo.GrupoId as GrupoAprobadorId',
																	'historial_solicitud.Id as HistorialId', 'historial_solicitud.EstadoEtapaFlujoId',
																	'historial_solicitud.updated_at as FechaUpdated',
																	DB::raw('GROUP_CONCAT(atributo.Nombre) as Atributos'),
																	DB::raw('(
																		SELECT CONCAT(persona_solicitante.Nombre, " ", persona_solicitante.Apellido)
																		FROM usuario
																		JOIN persona AS persona_solicitante ON persona_solicitante.UsuarioId = usuario.Id
																		WHERE usuario.Id = solicitud.UsuarioSolicitanteId
																	) as UsuarioNombre')
																	)
															->join('persona','persona.Id','=','solicitud.PersonaId')
															->join('centro_de_costo','centro_de_costo.Id','=','solicitud.CentroCostoId')
															->join('historial_solicitud', function ($join) {
																$join->on('historial_solicitud.SolicitudId', '=', 'solicitud.Id')
																	->where('historial_solicitud.created_at', '=', DB::raw('(
																						SELECT MAX(created_at) 
																						FROM historial_solicitud 
																						WHERE SolicitudId = solicitud.Id
																						)'));
															})
															->join('estado_flujo','estado_flujo.Id','=','historial_solicitud.EstadoFlujoId')
															//->where('historial_solicitud.EstadoSolicitudId','=', 1)
															//->orWhere('historial_solicitud.EstadoSolicitudId','=', 2)
															->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')                                
															->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
															->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
															->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
															->join('flujo','flujo.Id','=','movimiento.FlujoId')
															->join('orden_flujo','orden_flujo.FlujoId','=','flujo.Id')
															->where('orden_flujo.EstadoFlujoId', '=', DB::raw('estado_flujo.Id'))
															->groupBy('solicitud.Id', 'NombreCompleto','RUT', 'CentroCosto', 'FechaCreado', 'FechaUpdated', 'EstadoSolicitudId', 
															'EstadoFlujo', 'Movimiento','MovimientoIdd', 'NombreFlujo', 'HistorialId','FlujoIdd','UsuarioSolicitanteId','GrupoAprobadorId','EstadoEtapaFlujoId');
															//->get();
															
										
		return $solicitudes;
	}
	public static function getSolicitudesListar(int $modo, string $condicional,int $userId, $flujos){
		// SI variable condicional es < 3 Muestra Solicitudes activas
		// SI variable condicional es = 3 Muestra Solicitudes terminadas 

		// Modo 1, solo ver sus propias solicitudes
		// Modo 2, ver sus solicitudes y todas aquellas que en que su grupo participe
		// Modo 3, ver todas las solicitudes
		
		$solicitudes= Solicitud::querySolicitudes();

		if( $modo == 1 ){ // Modo 1, solo ver sus propias solicitudes
			
			$solicitudes = $solicitudes->where('historial_solicitud.EstadoSolicitudId',$condicional, 3)
										->where('solicitud.UsuarioSolicitanteId','=', $userId)
										->get();				
		}elseif( $modo == 2){ // Modo 2, ver sus solicitudes y todas aquellas que en que su grupo participe
			
			/*$solicitudes = $solicitudes->where('historial_solicitud.EstadoSolicitudId',$condicional, 3)
										->whereIn('flujo.Id', $flujos->pluck('FlujoId')->toArray())
										->orWhere('solicitud.UsuarioSolicitanteId','=', $userId)
										->get();*/

			$solicitudes = $solicitudes->where('historial_solicitud.EstadoSolicitudId', $condicional, 3)
										->where(function ($query) use ($flujos, $userId) {
											$query->whereIn('flujo.Id', $flujos->pluck('FlujoId')->toArray())
												  ->orWhere('solicitud.UsuarioSolicitanteId', '=', $userId);
										})
										->get();
											

		}elseif( $modo == 3){ // Modo 3, ver todas las solicitudes

			$solicitudes = $solicitudes->where('historial_solicitud.EstadoSolicitudId',$condicional, 3)
										->get();				
		}
		return $solicitudes;

															
							
	}
	public static function getSolicitudesId(int $solicitudId){
		$solicitudes= Solicitud::querySolicitudes();
		$solicitudes = $solicitudes->where('solicitud.Id','=', $solicitudId)
									->get();
		return $solicitudes;
	}

	public static function getSolicitudId_paraEnviarCorreo(int $solicitudId){
			// SI variable condicional es < 3 Muestra Solicitudes activas
			// SI variable condicional es = 3 Muestra Solicitudes terminadas 
	
			// Modo 1, solo ver sus propias solicitudes
			// Modo 2, ver sus solicitudes y todas aquellas que en que su grupo participe
			// Modo 3, ver todas las solicitudes
	
			// Aux = 0 -> Listar
			// Aux > Get One
	
			$solicitudes= Solicitud::select('solicitud.Id',DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) AS NombreCompleto"), 'persona.Rut as RUT',
																		'centro_de_costo.Nombre as CentroCosto','movimiento.Nombre as Movimiento','movimiento.Id as MovimientoIdd',
																		DB::raw('CONCAT("[", GROUP_CONCAT(JSON_OBJECT(
																												"Nombre", atributo.Nombre, 
																												"Fecha1", compuesta.Fecha1,
																												"Fecha2", compuesta.Fecha2
																											)), "]") as Atributos'),
																		DB::raw('(
																			SELECT CONCAT(persona_solicitante.Nombre, " ", persona_solicitante.Apellido)
																			FROM usuario
																			JOIN persona AS persona_solicitante ON persona_solicitante.UsuarioId = usuario.Id
																			WHERE usuario.Id = solicitud.UsuarioSolicitanteId
																		) as NombreSolicitante'),																		
																		'historial_solicitud.updated_at as FechaUpdated',
																		'estado_flujo.Nombre as EstadoFlujo',

																		)																		
																->join('persona','persona.Id','=','solicitud.PersonaId')
																->join('centro_de_costo','centro_de_costo.Id','=','solicitud.CentroCostoId')
																->join('historial_solicitud', function ($join) {
																	$join->on('historial_solicitud.SolicitudId', '=', 'solicitud.Id')
																		->where('historial_solicitud.created_at', '=', DB::raw('(
																							SELECT MAX(created_at) 
																							FROM historial_solicitud 
																							WHERE SolicitudId = solicitud.Id
																							)'));
																})
																->join('estado_flujo','estado_flujo.Id','=','historial_solicitud.EstadoFlujoId')
																//->where('historial_solicitud.EstadoSolicitudId','=', 1)
																//->orWhere('historial_solicitud.EstadoSolicitudId','=', 2)
																->join('compuesta','compuesta.SolicitudId','=','solicitud.Id')                                
																->join('movimiento_atributo','movimiento_atributo.Id','=','compuesta.MovimientoAtributoId')
																->join('movimiento','movimiento.Id','=','movimiento_atributo.MovimientoId')
																->join('atributo','atributo.Id','=','movimiento_atributo.AtributoId')
																->join('flujo','flujo.Id','=','movimiento.FlujoId')
																->join('orden_flujo','orden_flujo.FlujoId','=','flujo.Id')
																->where('orden_flujo.EstadoFlujoId', '=', DB::raw('estado_flujo.Id'))
																->groupBy('solicitud.Id', 'NombreCompleto','RUT', 'CentroCosto', 
																			'Movimiento', 'MovimientoIdd','FechaUpdated','EstadoFlujo','UsuarioSolicitanteId'
																			)
																->where('solicitud.Id','=', $solicitudId)
																->get();
																
											
			return $solicitudes;
	
	}
}
