<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Storage
 * 
 * @property int $Id
 * @property string $Url
 * @property string $Nombre
 * @property int $SolicitudId
 * 
 * @property Solicitud $solicitud
 *
 * @package App\Models
 */
class Storage extends Model
{
	protected $table = 'storage';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'SolicitudId' => 'int'
        
	];

	protected $fillable = [
        'Nombre',
		'Url',
		'SolicitudId'
	];

	public function solicitud()
	{
		return $this->belongsTo(Solicitud::class, 'SolicituId');
	}


}
