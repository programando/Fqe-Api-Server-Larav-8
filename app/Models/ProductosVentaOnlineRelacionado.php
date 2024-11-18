<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class ProductosVentaOnlineRelacionado extends Model
{
	protected $table = 'productos_venta_online_relacionados';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'idproducto' => 'int',
		'idproducto_rlcndo' => 'int'
	];

	protected $fillable = [
		'idproducto',
		'idproducto_rlcndo'
	];

 

	public function Productos() {
		return $this->belongsTo(ProductosVentaOnline::class, 'idproducto_rlcndo', 'idproducto')
			->select('idproducto','idproducto_ppal', 'nomproducto');
	}

}
