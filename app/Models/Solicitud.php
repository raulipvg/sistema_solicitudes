<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Solicitud
 * 
 * @property int $Id
 * @property int $CostoSolicitud
 * @property int $PersonaId
 * @property int $CentroCostoId
 * @property int $ConsolidadoMesId
 * 
 * @property CentroDeCosto $centro_de_costo
 * @property ConsolidadoMe $consolidado_me
 * @property Persona $persona
 * @property Collection|Compuestum[] $compuesta
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 *
 * @package App\Models
 */
class Solicitud extends Model
{
	protected $table = 'solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'CostoSolicitud' => 'int',
		'PersonaId' => 'int',
		'CentroCostoId' => 'int',
		'ConsolidadoMesId' => 'int'
	];

	protected $fillable = [
		'CostoSolicitud',
		'PersonaId',
		'CentroCostoId',
		'ConsolidadoMesId'
	];

	public function centro_de_costo()
	{
		return $this->belongsTo(CentroDeCosto::class, 'CentroCostoId');
	}

	public function consolidado_me()
	{
		return $this->belongsTo(ConsolidadoMe::class, 'ConsolidadoMesId');
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}

	public function compuesta()
	{
		return $this->hasMany(Compuestum::class, 'SolicitudId');
	}

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'SolicitudId');
	}
}
