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
 * Class Grupo
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Descripcion
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Flujo[] $flujos
 * @property Collection|Privilegio[] $privilegios
 * @property Collection|Movimiento[] $grupo_movimientos
 * @property Collection|Movimiento[] $movimientos
 * @property Collection|OrdenFlujo[] $orden_flujos
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Grupo extends Model
{
	protected $table = 'grupo';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Enabled'
	];

	public function flujos()
	{
		return $this->hasMany(Flujo::class, 'GrupoId');
	}

	public function privilegios()
	{
		return $this->belongsToMany(Privilegio::class, 'grupo_privilegio', 'GrupoId', 'PrivilegioId')
					->withPivot('Id','Ver','Registrar', 'Editar', 'Eliminar')
					->withTimestamps();
	}

	public function grupo_movimientos()
	{
		return $this->belongsToMany(GrupoMovimiento::class, 'grupo_movimiento', 'GrupoId', 'MovimientoId')
					->withPivot('Id','Enabled')
					->withTimestamps();
	}

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'GrupoId');
	}

	public function orden_flujos()
	{
		return $this->hasMany(OrdenFlujo::class, 'GrupoId');
	}

	public function usuarios()
	{
		return $this->belongsToMany(Usuario::class, 'usuario_grupo', 'GrupoId', 'UsuarioId')
					->withPivot('Id', 'Enabled')
					->withTimestamps();
	}

	public function validate(array $data)
    {
        if(isset($data['Id'])){
            $id = $data['Id'];
        }else{
            $id = null;
        }

        $rules = [
            'Nombre' => [
				'required',
				'string',
				'max:255',
				Rule::unique('grupo','Nombre')->ignore($id, 'Id'),
			],
            'Descripcion' => 'string|max:255',
            'Enabled' => 'min:0|max:1'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
