<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoRecurso
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $GrupoId
 * @property int $PrivilegioId
 * 
 * @property Grupo $grupo
 * @property Recurso $recurso
 *
 * @package App\Models
 */
class GrupoRecurso extends Model
{
	protected $table = 'grupo_recurso';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'GrupoId' => 'int',
		'PrivilegioId' => 'int'
	];

	protected $fillable = [
		'GrupoId',
		'PrivilegioId'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function recurso()
	{
		return $this->belongsTo(Recurso::class, 'PrivilegioId');
	}
}
