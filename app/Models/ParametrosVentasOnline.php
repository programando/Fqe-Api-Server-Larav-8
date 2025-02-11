<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametrosVentasOnline extends Model
{
	protected $table = 'parametros_ventas_online';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'prcntje_utldad' => 'float',
		'prcntje_iva' => 'float',
		'prcntje_cmsion' => 'float',
		'prcntje_seguro' => 'float',
		'prcntje_manejo' => 'float',
		'payu_prcntje' => 'float',
		'payu_vr_fijo' => 'float',
		'kg_max_envio' => 'float',
		'vr_min_envio' => 'float',
		'vr_kg_ini_urb' => 'float',
		'vr_kg_ini_nac' => 'float',
		'vr_kg_adc_urb' => 'float',
		'vr_kg_adc_nac' => 'float'
	];

	protected $fillable = [
		'prcntje_utldad',
		'prcntje_iva',
		'prcntje_cmsion',
		'prcntje_seguro',
		'prcntje_manejo',
		'payu_prcntje',
		'payu_vr_fijo',
		'kg_max_envio',
		'vr_min_envio',
		'vr_kg_ini_urb',
		'vr_kg_ini_nac',
		'vr_kg_adc_urb',
		'vr_kg_adc_nac'
	];


	public static function Listar (  ) {
		return self::all();
	}
	 
	
}
