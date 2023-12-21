<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'GoogleId' => 'int',
		'Enabled' => 'int',
		'PersonaId' => 'int'
	];

	protected $fillable = [
		'Username',
		'Password',
		'Email',
		'GoogleId',
		'Enabled',
		'PersonaId'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
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
}
