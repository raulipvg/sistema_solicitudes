<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Atributo
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $ValorReferencia
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Movimiento[] $movimientos
 *
 * @package App\Models
 */
class Atributo extends Model
{
	protected $table = 'atributo';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'ValorReferencia' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'ValorReferencia',
		'Enabled'
	];

	public function movimientos()
	{
		return $this->belongsToMany(Movimiento::class, 'movimiento_atributo', 'AtributoId', 'MovimientoId')
					->withPivot('Id')
					->withTimestamps();
	}
}
