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
 * Class Atributo
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $ValorReferencia
 * @property int $TipoMonedaId
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Movimiento[] $movimientos
 * @property TipoMoneda $tipoMoneda
 *
 * @package App\Models
 */
class Atributo extends Model
{
	protected $table = 'atributo';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'ValorReferencia' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'ValorReferencia',
        'TipoMonedaId',
		'Enabled'
	];

	public function movimientos()
	{
		return $this->belongsToMany(Movimiento::class, 'movimiento_atributo', 'AtributoId', 'MovimientoId')
					->withPivot('Id')
					->withTimestamps();
	}

    public function tipoMoneda()
{
    return $this->belongsTo(TipoMoneda::class, 'TipoMonedaId');
}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'Nombre' => [
                'required',
                'string',
                'max:255',
            ],
            'ValorReferencia' => 'required|min:0',
            'Enabled' => 'required|min:0|max:1'
        ];
        $messages = [
			'Nombre.unique'=> 'El Nombre ya está en uso.',
            'ValorReferencia.required' => 'El valor de referencia no puede estar vacío.',
			'ValorReferencia.min' => 'El valor de referencia no puede ser menor a cero.',
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
