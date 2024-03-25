<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class UsuarioGrupo
 * 
 * @property int $Id
 * @property int $AtributoId
 * @property int $TipoId
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Grupo $grupo
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class AtributoTipo extends Model
{
	protected $table = 'atributo_tipo';
	protected $primaryKey = 'Id';
	public $incrementing = true;
    public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'AtributoId' => 'int',
		'TipoId' => 'int'
	];

	protected $fillable = [
		'AtributoId',
		'TipoId'
	];

	public function tipo()
	{
		return $this->belongsTo(Tipo::class, 'TipoId');
	}

	public function usuario()
	{
		return $this->belongsTo(Atributo::class, 'AtributoId');
	}

	
}
