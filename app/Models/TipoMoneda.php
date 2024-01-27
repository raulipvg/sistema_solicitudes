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
 * @property string $Nivel
 * @property string $Mensaje
 * @property string $Contexto
 *
 * @package App\Models
 */
class TipoMoneda extends Model
{
	protected $table = 'tipomoneda';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
	];
}
