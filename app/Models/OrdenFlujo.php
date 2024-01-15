<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdenFlujo
 * 
 * @property int $Id
 * @property int $Nivel
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $EstadoSolicitudId
 * @property int $GrupoId
 * @property int $Pivot
 * @property int $FlujoId
 * @property int $EstadoFlujoId 
 * 
 * @property OrdenFlujo|null $orden_flujo
 * @property EstadoFlujo $estado_flujo
 * @property Flujo $flujo
 * @property Grupo $grupo
 * @property Collection|OrdenFlujo[] $orden_flujos
 *
 * @package App\Models
 */
class OrdenFlujo extends Model
{
	protected $table = 'orden_flujo';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Nivel' => 'int',
		'FlujoId' => 'int',
		'EstadoFlujoId' => 'int',
		'GrupoId' => 'int',
		'Pivot' => 'int'
	];

	protected $fillable = [
		'Nivel',
		'FlujoId',
		'EstadoFlujoId',
		'GrupoId',
		'Pivot'
	];


	public function estado_flujo()
	{
		return $this->belongsTo(EstadoFlujo::class, 'EstadoFlujoId');
	}

	public function flujo()
	{
		return $this->belongsTo(Flujo::class, 'FlujoId');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

}
