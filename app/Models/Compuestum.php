<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Compuestum
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $MovimientoAtributoId
 * @property int $SolicitudId
 * 
 * @property MovimientoAtributo $movimiento_atributo
 * @property Solicitud $solicitud
 *
 * @package App\Models
 */
class Compuestum extends Model
{
	protected $table = 'compuesta';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'MovimientoAtributoId' => 'int',
		'SolicitudId' => 'int'
	];

	protected $fillable = [
		'MovimientoAtributoId',
		'SolicitudId'
	];

	public function movimiento_atributo()
	{
		return $this->belongsTo(MovimientoAtributo::class, 'MovimientoAtributoId');
	}

	public function solicitud()
	{
		return $this->belongsTo(Solicitud::class, 'SolicitudId');
	}
}
