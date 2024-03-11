<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Exception;
use Illuminate\Support\Carbon;
/**
 * Class Log
 * 
 * @property int $Id
 * @property int $ToCLP
 * @property int $TipoMonedaId
 * @property int $ConsolidadoId
 *
 * @package App\Models
 */
class TipoCambio extends Model
{
	protected $table = 'tipo_cambio';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'Id' => 'int',
        'ToCLP'=> 'int',
        'TipoMonedaId'=> 'int',
        'ConsolidadoId'=> 'int',

	];

	protected $fillable = [
		'ToCLP',
		'TipoMonedaId',
        'ConsolidadoId',
		'updated_at'
	];

	static function CreaMoneda($url,$tipoMoneda,$consolidado){
		$apiUrl = 'https://mindicador.cl/api'.$url;
		if ( ini_get('allow_url_fopen') ) {
            $valor = file_get_contents($apiUrl);
        } else {
            //De otra forma utilizamos cURL
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $valor = curl_exec($curl);
            curl_close($curl);
        }
		$valor = json_decode($valor);
		$valor = round($valor->serie['0']->valor);

		$moneda = TipoCambio::updateOrCreate([
			'TipoMonedaId' => $tipoMoneda,
			'ConsolidadoId' => $consolidado
			], // Busca por el ID proporcionado
			[
				'ToCLP'=> $valor,
				'TipoMonedaId' => $tipoMoneda,
				'ConsolidadoId' => $consolidado,
				'updated_at' => Carbon::now()
			]
		);
		return $moneda;
	}
}
