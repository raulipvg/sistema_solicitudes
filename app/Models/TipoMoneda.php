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
 * @property string $Nombre
 * @property string $Simbolo
 *
 * @package App\Models
 */
class TipoMoneda extends Model
{
	protected $table = 'tipo_moneda';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Simbolo'
	];
}
