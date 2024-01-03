<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistorialSolicitud
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $UsuarioId
 * @property int $EstadoFlujoId
 * @property int $EstadoSolicitudId
 * @property int $SolicitudId
 * 
 * @property EstadoFlujo $estado_flujo
 * @property Solicitud $solicitud
 * @property EstadoSolicitud $estado_solicitud
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class HistorialSolicitud extends Model
{
	protected $table = 'historial_solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'UsuarioId' => 'int',
		'EstadoFlujoId' => 'int',
		'EstadoSolicitudId' => 'int',
		'SolicitudId' => 'int'
	];

	protected $fillable = [
		'UsuarioId',
		'EstadoFlujoId',
		'EstadoSolicitudId',
		'SolicitudId'
	];

	public function estado_flujo()
	{
		return $this->belongsTo(EstadoFlujo::class, 'EstadoFlujoId');
	}

	public function estado_solicitud()
	{
		return $this->belongsTo(EstadoSolicitud::class, 'EstadoSolicitudId');
	}

	public function solicitud()
	{
		return $this->belongsTo(Solicitud::class, 'SolicitudId');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioId');
	}
}
