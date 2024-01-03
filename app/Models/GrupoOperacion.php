<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoOperacion
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $GrupoId
 * @property int $OperacionId
 * 
 * @property Grupo $grupo
 * @property Operacion $operacion
 *
 * @package App\Models
 */
class GrupoOperacion extends Model
{
	protected $table = 'grupo_operacion';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'GrupoId' => 'int',
		'OperacionId' => 'int'
	];

	protected $fillable = [
		'GrupoId',
		'OperacionId'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function operacion()
	{
		return $this->belongsTo(Operacion::class, 'OperacionId');
	}
}
