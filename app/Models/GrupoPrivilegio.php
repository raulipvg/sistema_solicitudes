<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoPrivilegio
 * 
 * @property int $Id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $GrupoId
 * @property int $PrivilegioId
 * 
 * @property Grupo $grupo
 * @property Privilegio $privilegio
 *
 * @package App\Models
 */
class GrupoPrivilegio extends Model
{
	protected $table = 'grupo_privilegio';
	protected $primaryKey = 'Id';
	public $incrementing = false;

	protected $casts = [
		'Id' => 'int',
		'GrupoId' => 'int',
		'PrivilegioId' => 'int'
	];

	protected $fillable = [
		'GrupoId',
		'PrivilegioId'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'GrupoId');
	}

	public function privilegio()
	{
		return $this->belongsTo(Privilegio::class, 'PrivilegioId');
	}
}
