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
 * @property string $Descripcion
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Grupo[] $grupos
 *
 * @package App\Models
 */
class Recurso extends Model
{
	protected $table = 'recurso';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Enabled'
	];

	public function grupos()
	{
		return $this->belongsToMany(Grupo::class, 'grupo_recurso', 'PrivilegioId', 'GrupoId')
					->withPivot('Id')
					->withTimestamps();
	}
}
