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
 * @property int $Enabled
 * @property int $Ver
 * @property int $Registrar
 * @property int $Editar
 * @property int $Eliminar
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
	public $incrementing = true;
	public $timestamps = true;


	protected $casts = [
		'Id' => 'int',
		'GrupoId' => 'int',
		'PrivilegioId' => 'int',
		'Enabled'=> 'int',
		'Ver'=> 'int',
		'Registrar'=> 'int',
		'Editar'=> 'int',
		'Eliminar' => 'int'		
	];

	protected $fillable = [
		'GrupoId',
		'PrivilegioId',
		'Enabled',
		'Ver',
		'Registrar',
		'Editar',
		'Eliminar'
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
