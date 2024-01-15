<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class HistorialSolicitud
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $EstadoFlujoId
 * @property int $EstadoEtapaFlujoId
 * @property int $SolicitudId
 * @property int $EstadoSolicitudId
 * @property int $UsuarioId
 * 
 * @property EstadoFlujo $estado_flujo
 * @property Solicitud $solicitud
 * @property EstadoSolicitud $estado_solicitud
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class HistorialSolicitud extends Model
{
	protected $table = 'historial_solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'EstadoFlujoId' => 'int',
		'EstadoEtapaFlujoId' => 'int',	
		'SolicitudId' => 'int',
		'EstadoSolicitudId' => 'int',
		'UsuarioId' => 'int',
	];

	protected $fillable = [
		'EstadoFlujoId',
		'EstadoEtapaFlujoId',
		'SolicitudId',
		'EstadoSolicitudId',		
		'UsuarioId',
	];

	public function estado_flujo()
	{
		return $this->belongsTo(EstadoFlujo::class, 'EstadoFlujoId');
	}

	public function solicitud()
	{
		return $this->belongsTo(Solicitud::class, 'SolicitudId');
	}
	public function estado_solicitud()
	{
		return $this->belongsTo(EstadoSolicitud::class, 'EstadoSolicitudId');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioId');
	}

	public function validate(array $data){
		$id = isset($data['Id']) ? $data['Id'] : null;

		$rules = [
			'EstadoFlujoId' => 'required|numeric',
			'EstadoEtapaFlujoId' => 'required|numeric|min:1|max:3',
			'SolicitudId' => 'required|numeric',
			'EstadoSolicitudId' => 'required|numeric|min:1|max:3',
			'UsuarioId' => 'nullable|numeric',
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
}
