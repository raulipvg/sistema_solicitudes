<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoSolicitud
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $GrupoAutorizadoId
 * @property int $GrupoAccedidoId
 * 
 * @property Grupo $grupo
 * @property Movimiento $movimiento
 *
 * @package App\Models
 */
class GrupoSolicitud extends Model
{
	protected $table = 'grupo_solicitud';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;


	protected $casts = [
		'Id' => 'int',
		'GrupoAutorizadoId' => 'int',
		'GrupoAccedidoId' => 'int'
	];

	protected $fillable = [
		'GrupoAutorizadoId',
		'GrupoAccedidoId'
	];

	public function grupo_autorizado()
	{
		return $this->belongsTo(Grupo::class, 'GrupoAutorizadoId');
	}

	public function grupo_accedido()
	{
		return $this->belongsTo(Grupo::class, 'GrupoAccedidoId');
	}
}
