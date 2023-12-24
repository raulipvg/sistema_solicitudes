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
 * Class Empresa
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Rut
 * @property string $Email
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CentroDeCosto[] $centro_de_costos
 *
 * @package App\Models
 */
class Empresa extends Model
{
	protected $table = 'empresa';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Rut',
		'Email',
		'Enabled'
	];

	public function centro_de_costos()
	{
		return $this->hasMany(CentroDeCosto::class, 'EmpresaId');
	}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'Nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('empresa','Nombre')->ignore($id, 'Id'),
            ],
			'Rut' => [
                'required',
                'string',
                'max:13',
                Rule::unique('empresa','Rut')->ignore($id, 'Id'),
            ],
            'Email' => 'required|email|max:50',
            'Enabled' => 'required|min:0|max:1'
        ];
        $messages = [
            'Rut.unique' => 'El Rut ya está en uso.',
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
