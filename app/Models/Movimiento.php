<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Movimiento
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $FlujoId
 * @property int $GrupoId
 * 
 * @property Flujo $flujo
 * @property Grupo $grupo
 * @property Collection|Atributo[] $atributos
 *
 * @package App\Models
 */
class Movimiento extends Model
{
	protected $table = 'movimiento';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'FlujoId' => 'int',
		'GrupoId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Enabled',
		'FlujoId',
		'GrupoId'
	];

	public function flujo()
	{
		return $this->belongsTo(Flujo::class, 'FlujoId');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function atributos()
	{
		return $this->belongsToMany(Atributo::class, 'movimiento_atributo', 'MovimientoId', 'AtributoId')
					->withPivot('Id')
					->withTimestamps();
	}
}
