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
 * Class UsuarioGrupo
 * 
 * @property int $Id
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $UsuarioId
 * @property int $GrupoId
 * 
 * @property Grupo $grupo
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class UsuarioGrupo extends Model
{
	protected $table = 'usuario_grupo';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'UsuarioId' => 'int',
		'GrupoId' => 'int'
	];

	protected $fillable = [
		'Enabled',
		'UsuarioId',
		'GrupoId'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioId');
	}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
			'GrupoId' => 'required|numeric',
			'UsuarioId' => 'required|numeric',
            'Enabled' => 'required|min:0|max:1'
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
