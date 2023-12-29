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
class Log extends Model
{
	protected $table = 'logs';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nivel',
		'Mensaje',
		'Contexto'
	];
}
