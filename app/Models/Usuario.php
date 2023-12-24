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
 * Class Usuario
 * 
 * @property int $Id
 * @property string $Username
 * @property string|null $Password
 * @property string $Email
 * @property int|null $GoogleId
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $PersonaId
 * 
 * @property Persona $persona
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 * @property Collection|Grupo[] $grupos
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuario';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'GoogleId' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Username',
		'Password',
		'Email',
		'GoogleId',
		'Enabled'
	];

	public function persona()
	{
		return $this->hasOne(Persona::class, 'UsuarioId');
	}

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'UsuarioId');
	}

	public function grupos()
	{
		return $this->belongsToMany(Grupo::class, 'usuario_grupo', 'UsuarioId', 'GrupoId')
					->withPivot('Id', 'Enabled')
					->withTimestamps();
	}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'Username' => [
                'required',
                'string',
                'max:255',
				Rule::unique('usuario','Username')->ignore($id, 'Id'),
            ],
			'Password' => [
                'required',
                'string',
                'max:255'
            ],
			'Email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('usuario','Email')->ignore($id, 'Id')
            ],
			'GoogleId' => 'string|numeric',
            'Enabled' => 'required|min:0|max:1'
        ];
        $messages = [
            'Username.unique' => 'El Username ya está en uso.',
            'Email.unique' => 'El Email ya está en uso.',
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
