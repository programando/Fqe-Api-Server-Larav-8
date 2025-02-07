<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class ParametrosVentasOnline extends Model
{
	protected $table = 'parametros_ventas_online';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'prcntje_utldad' => 'float',
		'prcntje_cmsion' => 'float',
		'payu_prcntje' => 'float',
		'payu_vr_fijo' => 'float'
	];

	protected $fillable = [
		'prcntje_utldad',
		'prcntje_cmsion',
		'payu_prcntje',
		'payu_vr_fijo',
		'kg_max_envio',
		'prcntje_seguro',
		'vr_min_envio',
		'vr_kg_ini_urb',
		'vr_kg_ini_nac',
		'vr_kg_adc_urb',
		'vr_kg_adc_nac',
		'prcntje_manejo',
		'prcntje_iva',
	];

 
	
	public static function Listar (  ) {
		return self::all();
	}
	 

}
