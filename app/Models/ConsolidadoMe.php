<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsolidadoMe
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $FechaTermino
 * @property int $EstadoConsolidadoId
 * 
 * @property EstadoConsolidado $estado_consolidado
 * @property Collection|Interno[] $internos
 * @property Collection|OrdenDeCompra[] $orden_de_compras
 * @property Collection|Solicitud[] $solicituds
 * @property Collection|TipoCambio[] $tipo_cambio
 *
 * @package App\Models
 */
class ConsolidadoMe extends Model
{
	protected $table = 'consolidado_mes';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'FechaTermino' => 'datetime',
		'EstadoConsolidadoId' => 'int'
	];

	protected $fillable = [
		'FechaTermino',
		'EstadoConsolidadoId'
	];

	public function estado_consolidado()
	{
		return $this->belongsTo(EstadoConsolidado::class, 'EstadoConsolidadoId');
	}

	public function internos()
	{
		return $this->hasMany(Interno::class, 'ConsolidadoMesId');
	}

	public function orden_de_compras()
	{
		return $this->hasMany(OrdenDeCompra::class, 'ConsolidadoMesId');
	}

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'ConsolidadoMesId');
	}

	public function tipo_cambios()
	{
		return $this->hasMany(TipoCambio::class,'ConsolidadoId');
	}
}
