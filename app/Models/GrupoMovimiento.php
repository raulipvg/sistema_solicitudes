<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoOperacion
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $GrupoId
 * @property int $MovimientoId
 * 
 * @property Grupo $grupo
 * @property Movimiento $movimiento
 *
 * @package App\Models
 */
class GrupoMovimiento extends Model
{
	protected $table = 'grupo_movimiento';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;


	protected $casts = [
		'Id' => 'int',
		'GrupoId' => 'int',
		'MovimientoId' => 'int',
		'Enabled'=> 'int'
	];

	protected $fillable = [
		'GrupoId',
		'MovimientoId',
		'OperacionId',
		'Enabled'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function movimiento()
	{
		return $this->belongsTo(Movimiento::class, 'MovimientoId');
	}
}
