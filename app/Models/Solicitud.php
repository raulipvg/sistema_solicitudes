<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
			'FechaDesde' => 'required|date',
			'FechaHasta' => 'required|date',
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
