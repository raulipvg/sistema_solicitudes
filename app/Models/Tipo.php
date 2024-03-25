<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Atributo
 * 
 * @property int $Id
 * @property int $Nombre
 * 
 * @package App\Models
 */
class Tipo extends Model
{
	protected $table = 'tipo';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
	];

	protected $fillable = [
		'Nombre'
	];


	
}
