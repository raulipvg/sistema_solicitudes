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
 * Class Compuesta
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $MovimientoAtributoId
 * @property int $SolicitudId
 * @property int $CostoReal
 * @property int $TipoMonedaId
 * @property int $Caracteristica
 * 
 * @property MovimientoAtributo $movimiento_atributo
 * @property Solicitud $solicitud
 *
 * @package App\Models
 */
class Compuesta extends Model
{
	protected $table = 'compuesta';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'MovimientoAtributoId' => 'int',
		'SolicitudId' => 'int',
		'CostoReal'=> 'int',
		'TipoMonedaId'=> 'int',
	];

	protected $fillable = [
		'MovimientoAtributoId',
		'SolicitudId',
		'CostoReal',
		'TipoMonedaId',
		'Caracteristica',
	];

	public function movimiento_atributo()
	{
		return $this->belongsTo(MovimientoAtributo::class, 'MovimientoAtributoId');
	}

	public function solicitud()
	{
		return $this->belongsTo(Solicitud::class, 'SolicitudId');
	}

	public function tipo_moneda()
	{
		return $this->belongsTo(TipoMoneda::class, 'TipoMonedaId');
	}

	public function validate(array $data){
		$id = isset($data['Id']) ? $data['Id'] : null;

		$rules = [
			'MovimientoAtributoId' => 'required|numeric',
			'CostoReal' => 'nullable|numeric',
			'Caracteristica' => 'nullable|string',
			'SolicitudId' => 'required|numeric',
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
