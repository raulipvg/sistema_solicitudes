<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recurso
 * 
 * @property int $Id
 * @property string $Nombre
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $MovimientoId
 * 
 * @property Collection|Grupo[] $grupos
 *
 * @package App\Models
 */
class Operacion extends Model
{
	protected $table = 'operacion';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
	];

	protected $fillable = [
		'Nombre',
	];

	public function grupos()
	{
		return $this->belongsToMany(Grupo::class, 'grupo_operacion', 'OperacionId', 'GrupoId')
					->withPivot('Id')
					->withTimestamps();
	}

	public function movimiento()
	{
		return $this->belongsTo(Movimiento::class, 'MovimientoId');
	}
}
