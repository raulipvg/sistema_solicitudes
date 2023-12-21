<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Flujo
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $AreaId
 * @property int $GrupoId
 * 
 * @property Area $area
 * @property Grupo $grupo
 * @property Collection|Movimiento[] $movimientos
 * @property Collection|OrdenFlujo[] $orden_flujos
 *
 * @package App\Models
 */
class Flujo extends Model
{
	protected $table = 'flujo';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'AreaId' => 'int',
		'GrupoId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Enabled',
		'AreaId',
		'GrupoId'
	];

	public function area()
	{
		return $this->belongsTo(Area::class, 'AreaId');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'FlujoId');
	}

	public function orden_flujos()
	{
		return $this->hasMany(OrdenFlujo::class, 'FlujoId');
	}
}
