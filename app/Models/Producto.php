<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Folders;
class Producto extends Model
{
	protected $table = 'productos';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'idproducto' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'idproducto',
		'id_clse_prdcto',
		'nomproducto',
		'url_imagen',
		'dscrpcion',
		'inactivo'
	];

	 		public function getNomproductoAttribute ( $value ){
				return trim($value);
			}

	 		public function getDscrpcionAttribute ( $value ){
				return trim($value);
			}

	public function getUrlImagenAttribute( $value ) {  
        return  Folders::ProductsImages() .'/'. $value  ;
    }

}
