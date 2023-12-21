<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Rut
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $CentroCostoId
 * 
 * @property CentroDeCosto $centro_de_costo
 * @property Collection|Solicitud[] $solicituds
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'persona';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'CentroCostoId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Apellido',
		'Rut',
		'Enabled',
		'CentroCostoId'
	];

	public function centro_de_costo()
	{
		return $this->belongsTo(CentroDeCosto::class, 'CentroCostoId');
	}

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'PersonaId');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'PersonaId');
	}
}
