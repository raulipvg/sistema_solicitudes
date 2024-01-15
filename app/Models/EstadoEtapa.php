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
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 * @property Collection|Solicitud[] $solicitud
 *
 * @package App\Models
 */
class EstadoEtapa extends Model
{
	protected $table = 'estado_etapa';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;


	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'EstadoEtapaFlujoId');
	}
	
	
	
}
