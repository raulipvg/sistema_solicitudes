<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Interno
 * 
 * @property int $Id
 * @property int $CostoCC
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $CentroCostoId
 * @property int $ConsolidadoMesId
 * 
 * @property CentroDeCosto $centro_de_costo
 * @property ConsolidadoMe $consolidado_me
 *
 * @package App\Models
 */
class Interno extends Model
{
	protected $table = 'interno';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'CostoCC' => 'int',
		'CentroCostoId' => 'int',
		'ConsolidadoMesId' => 'int'
	];

	protected $fillable = [
		'CostoCC',
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
}
