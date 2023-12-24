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
 * Class CentroDeCosto
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $EmpresaId
 * 
 * @property Empresa $empresa
 * @property Collection|Interno[] $internos
 * @property Collection|Persona[] $personas
 * @property Collection|Solicitud[] $solicituds
 *
 * @package App\Models
 */
class CentroDeCosto extends Model
{
	protected $table = 'centro_de_costo';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'EmpresaId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Enabled',
		'EmpresaId'
	];

	public function empresa()
	{
		return $this->belongsTo(Empresa::class, 'EmpresaId');
	}

	public function internos()
	{
		return $this->hasMany(Interno::class, 'CentroCostoId');
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'CentroCostoId');
	}

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'CentroCostoId');
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
            'EmpresaId' => 'required|numeric',
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
