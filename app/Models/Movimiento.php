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
 * Class Movimiento
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property string $Adjunto
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $FlujoId
 * @property int $GrupoId
 * @property string $Mail
 * 
 * @property Flujo $flujo
 * @property Grupo $grupo
 * @property Collection|Atributo[] $atributos
 *
 * @package App\Models
 */
class Movimiento extends Model
{
	protected $table = 'movimiento';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'FlujoId' => 'int',
		'GrupoId' => 'int',
		'ConfigFecha'=> 'int',
		'Enabled' => 'int',
	];

	protected $fillable = [
		'Nombre',
		'FlujoId',
		'GrupoId',
		'Enabled',
		'Adjunto',
		'Mail'
	];

	public function flujo()
	{
		return $this->belongsTo(Flujo::class, 'FlujoId');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function atributos()
	{
		return $this->belongsToMany(Atributo::class, 'movimiento_atributo', 'MovimientoId', 'AtributoId')
					->withPivot('Id')
					->withTimestamps();
	}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'Nombre' => [
                'required',
                'max:255',
                Rule::unique('movimiento','Nombre')->ignore($id, 'Id'),
            ],
			'GrupoId' => 'required|min:0',
			'FlujoId' => 'required|min:0',
            'Enabled' => 'required|min:0|max:1'
        ];
        $messages = [
            'Grupo' => 'No se encuentra el grupo.',
			'Flujo' => 'No se encuentra el flujo.',
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
