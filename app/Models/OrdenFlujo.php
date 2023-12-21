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
 * @property int|null $AtrasId
 * @property int $FlujoId
 * @property int $EstadoSolicitudId
 * @property int $GrupoId
 * 
 * @property OrdenFlujo|null $orden_flujo
 * @property EstadoSolicitud $estado_solicitud
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
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Nivel' => 'int',
		'AtrasId' => 'int',
		'FlujoId' => 'int',
		'EstadoSolicitudId' => 'int',
		'GrupoId' => 'int'
	];

	protected $fillable = [
		'Nivel',
		'AtrasId',
		'FlujoId',
		'EstadoSolicitudId',
		'GrupoId'
	];

	public function orden_flujo()
	{
		return $this->belongsTo(OrdenFlujo::class, 'AtrasId');
	}

	public function estado_solicitud()
	{
		return $this->belongsTo(EstadoSolicitud::class, 'EstadoSolicitudId');
	}

	public function flujo()
	{
		return $this->belongsTo(Flujo::class, 'FlujoId');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function orden_flujos()
	{
		return $this->hasMany(OrdenFlujo::class, 'AtrasId');
	}
}
