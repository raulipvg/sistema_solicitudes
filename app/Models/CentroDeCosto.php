<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CentroDeCosto
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $EmpresaId
 * 
 * @property Empresa $empresa
 * @property Collection|Interno[] $internos
 * @property Collection|Persona[] $personas
 * @property Collection|Solicitud[] $solicituds
 *
 * @package App\Models
 */
class CentroDeCosto extends Model
{
	protected $table = 'centro_de_costo';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int',
		'EmpresaId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Enabled',
		'EmpresaId'
	];

	public function empresa()
	{
		return $this->belongsTo(Empresa::class, 'EmpresaId');
	}

	public function internos()
	{
		return $this->hasMany(Interno::class, 'CentroCostoId');
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'CentroCostoId');
	}

	public function solicituds()
	{
		return $this->hasMany(Solicitud::class, 'CentroCostoId');
	}
}
