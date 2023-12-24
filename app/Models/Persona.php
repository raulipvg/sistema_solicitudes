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
 * Class Persona
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Rut
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $CentroCostoId
 * 
 * @property CentroDeCosto $centro_de_costo
 * @property Collection|Solicitud[] $solicituds
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'persona';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'CentroCostoId' => 'int',
		'UsuarioId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Apellido',
		'Rut',
		'Enabled',
		'CentroCostoId',
		'UsuarioId'
	];

	public function centro_de_costo()
	{
		return $this->belongsTo(CentroDeCosto::class, 'CentroCostoId');
	}
	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioId');
	}

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'PersonaId');
	}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'Nombre' => [
                'required',
                'string',
                'max:255'
            ],
			'Apellido' => [
                'required',
                'string',
                'max:255'
            ],
			'Rut' => [
                'required',
                'string',
                'max:13',
                Rule::unique('persona','Rut')->ignore($id, 'Id'),
            ],
            'Enabled' => 'required|min:0|max:1',
			'CentroCostoId' => 'required|numeric',
			'UsuarioId' => [
				'numeric',
				Rule::unique('persona','UsuarioId')->ignore($id, 'Id'),
			],
        ];
        $messages = [
            'Rut.unique' => 'El Rut ya está en uso.',
            'UsuarioId.unique'=> 'El Usuario ya está en uso.',
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
