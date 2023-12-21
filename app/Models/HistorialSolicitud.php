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
 * @property int $EstadoSolicitudId
 * @property int $SolicitudId
 * 
 * @property EstadoSolicitud $estado_solicitud
 * @property Solicitud $solicitud
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class HistorialSolicitud extends Model
{
	protected $table = 'historial_solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'UsuarioId' => 'int',
		'EstadoSolicitudId' => 'int',
		'SolicitudId' => 'int'
	];

	protected $fillable = [
		'UsuarioId',
		'EstadoSolicitudId',
		'SolicitudId'
	];

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
