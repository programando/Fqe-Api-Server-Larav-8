<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $idregistro
 * @property int $idproducto
 * @property string $id_clse_prdcto
 * @property string $nomproducto
 * @property string $url_imagen
 * @property string $dscrpcion
 * @property bool $inactivo
 *
 * @package App\Models
 */
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

}
