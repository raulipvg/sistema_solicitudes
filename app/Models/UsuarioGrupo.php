<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
}
