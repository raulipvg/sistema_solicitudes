<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Usuario
 * 
 * @property int $Id
 * @property string $Username
 * @property string|null $Password
 * @property string $Email
 * @property int|null $GoogleId
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $PersonaId
 * 
 * @property Persona $persona
 * @property Collection|HistorialSolicitud[] $historial_solicituds
 * @property Collection|Grupo[] $grupos
 *
 * @package App\Models
 */
class Usuario extends Authenticatable
{
	protected $table = 'usuario';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'Username',
		'Password',
		'Email',
		'GoogleId',
		'Enabled'
	];

    public function getAuthPassword()
	{
		return $this->Password;
	}
	public function persona()
	{
		return $this->hasOne(Persona::class, 'UsuarioId');
	}

	public function historial_solicituds()
	{
		return $this->hasMany(HistorialSolicitud::class, 'UsuarioId');
	}

	public function grupos()
	{
		return $this->belongsToMany(Grupo::class, 'usuario_grupo', 'UsuarioId', 'GrupoId')
					->withPivot('Id', 'Enabled')
					->withTimestamps();
	}

    public function gruposHabilidatos()
    {
        return $this->belongsToMany(Grupo::class, 'usuario_grupo', 'UsuarioId', 'GrupoId')                       
                        ->where('usuario_grupo.Enabled', '=', 1)
                        ->where('grupo.Enabled', '=', 1)
                        ->pluck('grupo.Id');
                                    
    }
	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'Username' => [
                'required',
                'string',
                'max:255',
				Rule::unique('usuario','Username')->ignore($id, 'Id'),
            ],
			'Password' => [
                'nullable',
                'string',
                'max:255'
            ],
			'Email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('usuario','Email')->ignore($id, 'Id')
            ],
			'GoogleId' => 'nullable|string|numeric',
            'Enabled' => 'required|min:0|max:1'
        ];
        $messages = [
            'Username.unique' => 'El Username ya está en uso.',
            'Email.unique' => 'El Email ya está en uso.',
            '*' => 'Hubo un problema con el campo :attribute.'
            // Agrega más mensajes personalizados aquí según tus necesidades
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $databaseErrors = $errors->getMessages();

            foreach ($databaseErrors as $fieldErrors) {
                foreach ($fieldErrors as $fieldError) {
                    if (strpos($fieldError, 'database') !== false) {
                        //Problema de BD
                        $messages['*'] = 'Error';
                        break 2; // Salir de los bucles si se encuentra un error de la base de datos
                    }
                }
            }
            throw new ValidationException($validator);
        }
    }

    public function gruposPrivilegios($privilegioId)
	{
		$query = $this->belongsToMany(Grupo::class, 'usuario_grupo', 'UsuarioId', 'GrupoId')
                    ->select([
                        //'grupo_privilegio.Id',
                        //'grupo_privilegio.GrupoId',
                        'grupo_privilegio.PrivilegioId',
                        'grupo_privilegio.Ver',
                        'grupo_privilegio.Registrar',
                        'grupo_privilegio.Editar', 
                        'grupo_privilegio.Eliminar',    
                    ])
                    ->where('grupo.Enabled','=', 1)
                    ->where('usuario_grupo.Enabled','=',1)
                    ->where('grupo_privilegio.PrivilegioId','=', $privilegioId)
					->join('grupo_privilegio','grupo_privilegio.GrupoId','=','grupo.Id');
        
        
        return $query;
	}

    public function movimientosPuedeVer(){
        $query =Usuario::select([
                                'movimiento.Id',
                                'movimiento.Nombre',
                             ])
                            ->join('usuario_grupo','usuario_grupo.UsuarioId','=','usuario.Id')
                            ->join('grupo','grupo.Id','=','usuario_grupo.GrupoId')
                            ->join('grupo_movimiento','grupo_movimiento.GrupoId','=','grupo.Id')
                            ->join('movimiento','movimiento.Id','=','grupo_movimiento.MovimientoId')
                            ->where('usuario.Id','=', $this->Id)
                            ->where('usuario_grupo.Enabled','=', 1)                            
                            ->where('grupo.Enabled','=',1)
                            ->where('movimiento.Enabled','=',1)  
                            ->groupBy('movimiento.Id', 'movimiento.Nombre')
                            ->get();
        return $query;
    }

    public function personasPuedeVer(){

        

        $personasExternas = Persona::select('Id','Rut',
                                DB::raw("CONCAT(UCASE(SUBSTRING(persona.Nombre, 1, 1)), LCASE(SUBSTRING(persona.Nombre FROM 2)), ' ', UCASE(SUBSTRING(persona.Apellido, 1, 1)), LCASE(SUBSTRING(persona.Apellido FROM 2))) AS NombreCompleto"),
                                'CentroCostoId')
                                ->where('Enabled',1)
                                ->whereNull('persona.UsuarioId')
                                ->orderBy('NombreCompleto','asc')
                                ->get();

        $accesoGrupos =Usuario::select(
                                'grupo_solicitud.GrupoAccedidoId',
                             )
                            ->join('usuario_grupo','usuario_grupo.UsuarioId','=','usuario.Id')
                            ->join('grupo','grupo.Id','=','usuario_grupo.GrupoId')
                            ->join('grupo_solicitud','grupo_solicitud.GrupoAutorizadoId','=','grupo.Id')
                            ->where('usuario.Id','=', $this->Id)
                            ->where('usuario_grupo.Enabled','=', 1)                            
                            ->where('grupo.Enabled','=',1)
                            ->groupBy('grupo_solicitud.GrupoAccedidoId') 
                            ->pluck('GrupoAccedidoId')->toArray();

        $PersonasPosibles = Persona::select('persona.Id','persona.Rut',
                                    DB::raw("CONCAT(UCASE(SUBSTRING(persona.Nombre, 1, 1)), LCASE(SUBSTRING(persona.Nombre FROM 2)), ' ', UCASE(SUBSTRING(persona.Apellido, 1, 1)), LCASE(SUBSTRING(persona.Apellido FROM 2))) AS NombreCompleto"),
                                    'persona.CentroCostoId')
                    ->join('usuario','usuario.Id','=','persona.UsuarioId')
                    ->join('usuario_grupo','usuario_grupo.UsuarioId','=','usuario.Id')
                    ->join('grupo','grupo.Id','=','usuario_grupo.GrupoId')
                    ->where('persona.Enabled',1)
                    ->where('usuario_grupo.Enabled','=',1)
                    ->where('grupo.Enabled','=',1)
                    ->orderBy('NombreCompleto','asc')
                    ->where(function ($query) use ($accesoGrupos) {
                        $query->whereIn('grupo.Id', $accesoGrupos);
                    })
                    ->groupBy('persona.Id','persona.Rut','NombreCompleto','persona.CentroCostoId') 
                    ->get();

        $personas = $personasExternas->merge($PersonasPosibles);



        return $personas;
    }
    public function puedeVer($privilegioId){
       //$flag=  $this->gruposEnabled()->get();
       $flag=  $this->gruposPrivilegios($privilegioId)
                        ->where('Ver','=',1)->exists();   
       return $flag;
    }

    public function puedeRegistrar($privilegioId){
        //$flag=  $this->gruposEnabled()->get();
        $flag=  $this->gruposPrivilegios($privilegioId)
                        ->where('Registrar','=',1)->exists();
        return $flag;
     }

     public function puedeEditar($privilegioId){
        //$flag=  $this->gruposEnabled()->get();
        $flag=  $this->gruposPrivilegios($privilegioId)
                        ->where('Editar','=',1)->exists();     
        return $flag;
     }
     public function puedeEliminar($privilegioId){
        //$flag=  $this->gruposEnabled()->get();
        $flag=  $this->gruposPrivilegios($privilegioId)
                        ->where('Eliminar','=',1)->exists();    
        return $flag;
     }

     public function todoPuedeVer(){
         $query = $this
                    ->selectRaw('grupo_privilegio.PrivilegioId, MAX(grupo_privilegio.Ver = 1) as Ver')
                    ->where('grupo.Enabled','=', 1)
                    ->where('usuario_grupo.Enabled','=',1)
                    ->where('usuario.Id','=',$this->Id)
                    ->join('usuario_grupo','usuario_grupo.UsuarioId','=','usuario.Id')
                    ->join('grupo','grupo.Id','=','usuario_grupo.GrupoId')
					->join('grupo_privilegio','grupo_privilegio.GrupoId','=','grupo.Id')
                    ->groupBy('grupo_privilegio.PrivilegioId')
                    ->get();

        return $query;
     } 

}
