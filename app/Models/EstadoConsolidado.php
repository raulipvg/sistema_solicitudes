<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoConsolidado
 * 
 * @property int $Id
 * @property string $Nombre
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|ConsolidadoMe[] $consolidado_mes
 *
 * @package App\Models
 */
class EstadoConsolidado extends Model
{
	protected $table = 'estado_consolidado';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function consolidado_mes()
	{
		return $this->hasMany(ConsolidadoMe::class, 'EstadoConsolidadoId');
	}
}
