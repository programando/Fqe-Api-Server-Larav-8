<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
class MstroClasesPrdcto extends Model
{
	protected $table = 'mstro_clases_prdcto';
	protected $primaryKey = 'id_clse_prdcto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_clse_prdcto' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'nom_clse_prdcto',
		'inactivo'
	];


 			public function getnomClsePrdctoAttribute ( $value ){
				return trim($value);
			}


	public static function ClasesProductosPorLinea ( $IdLinea ) {
	 	return     DB::select(' call web_productos_clase_producto_linea ( ?)', array($IdLinea));
 }

}
