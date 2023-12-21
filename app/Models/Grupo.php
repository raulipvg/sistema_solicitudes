<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
 * @property Collection|Recurso[] $recursos
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
	public $incrementing = false;

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
					->withPivot('Id')
					->withTimestamps();
	}

	public function recursos()
	{
		return $this->belongsToMany(Recurso::class, 'grupo_recurso', 'GrupoId', 'PrivilegioId')
					->withPivot('Id')
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
}
