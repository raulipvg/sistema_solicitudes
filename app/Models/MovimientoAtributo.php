<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MovimientoAtributo
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $MovimientoId
 * @property int $AtributoId
 * 
 * @property Atributo $atributo
 * @property Movimiento $movimiento
 * @property Collection|Compuestum[] $compuesta
 *
 * @package App\Models
 */
class MovimientoAtributo extends Model
{
	protected $table = 'movimiento_atributo';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'MovimientoId' => 'int',
		'AtributoId' => 'int'
	];

	protected $fillable = [
		'MovimientoId',
		'AtributoId'
	];

	public function atributo()
	{
		return $this->belongsTo(Atributo::class, 'AtributoId');
	}

	public function movimiento()
	{
		return $this->belongsTo(Movimiento::class, 'MovimientoId');
	}

	public function compuesta()
	{
		return $this->hasMany(Compuestum::class, 'MovimientoAtributoId');
	}
}
