<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * 
 * @property int $Id
 * @property int $ToCLP
 * @property int $TipoMonedaId
 * @property int $ConsolidadoId
 *
 * @package App\Models
 */
class TipoCambio extends Model
{
	protected $table = 'tipo_cambio';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	//public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
        'ToCLP'=> 'int',
        'TipoMonedaId'=> 'int',
        'ConsolidadoId'=> 'int',

	];

	protected $fillable = [
		'ToCLP',
		'TipoMonedaId',
        'ConsolidadoId',
	];
}
