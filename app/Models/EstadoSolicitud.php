<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoSolicitud
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 * @property Collection|OrdenFlujo[] $orden_flujos
 *
 * @package App\Models
 */
class EstadoSolicitud extends Model
{
	protected $table = 'estado_solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Enabled'
	];

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'EstadoSolicitudId');
	}

	public function orden_flujos()
	{
		return $this->hasMany(OrdenFlujo::class, 'EstadoSolicitudId');
	}
}
