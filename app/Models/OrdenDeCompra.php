<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdenDeCompra
 * 
 * @property int $Id
 * @property int $CostoMes
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $ConsolidadoMesId
 * 
 * @property ConsolidadoMe $consolidado_me
 *
 * @package App\Models
 */
class OrdenDeCompra extends Model
{
	protected $table = 'orden_de_compra';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'CostoMes' => 'int',
		'ConsolidadoMesId' => 'int'
	];

	protected $fillable = [
		'CostoMes',
		'ConsolidadoMesId'
	];

	public function consolidado_me()
	{
		return $this->belongsTo(ConsolidadoMe::class, 'ConsolidadoMesId');
	}
}
