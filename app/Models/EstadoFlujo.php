<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Class EstadoSolicitud
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 * @property Collection|OrdenFlujo[] $orden_flujos
 *
 * @package App\Models
 */
class EstadoFlujo extends Model
{
	protected $table = 'estado_flujo';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;


	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Enabled'
	];

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'EstadoFlujo');
	}

	public function orden_flujos()
	{
		return $this->hasMany(OrdenFlujo::class, 'EstadoFlujoId');
	}
	
	public function validate(array $data){
		$id = isset($data['Id']) ? $data['Id'] : null;

		$rules = [
			'Nombre' => [
				'required',
				'string',
				'max:255',
				Rule::unique('estado_flujo','Nombre')->ignore($id, 'Id'),	
			],
			'Enabled' => 'required|min:0|max:1'
		];

		$messages = [
			'Nombre.unique'=> 'El Nombre ya está en uso.',
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
