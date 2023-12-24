<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Class Area
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Rut
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Flujo[] $flujos
 *
 * @package App\Models
 */
class Area extends Model
{
	protected $table = 'area';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Enabled'
	];

	public function flujos()
	{
		return $this->hasMany(Flujo::class, 'AreaId');
	}
	
	public function validate(array $data)
    {
        if(isset($data['Id'])){
            $id = $data['Id'];
        }else{
            $id = null;
        }


        $rules = [
            'Nombre' => 'required|string|max:50',
            'RUT' => [
                'required',
                'string',
                'max:50',
                Rule::unique('Comunidad','RUT')->ignore($id, 'Id'),
            ],
            'Correo' => 'required|email|max:50',
            'NumeroCuenta' => 'required|numeric',
            'TipoCuenta' => 'required|string',
            'Banco' => 'required|string',
            'CantPropiedades' => 'required|numeric',
            'FechaRegistro' => 'required|date',
            'Enabled' => 'required|min:1|max:2',
            'TipoComunidadId' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
