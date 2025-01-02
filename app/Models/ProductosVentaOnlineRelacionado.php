<?php

 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 
class ProductosVentaOnlineRelacionado extends Model
{
	protected $table = 'productos_venta_online_relacionados';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'idkeyproducto' => 'int',
		'idproducto' => 'int'
	];

	protected $fillable = [
		'idkeyproducto',
		'idproducto'
	];

	public function Productos()	{
		return $this->belongsTo(ProductosVentaOnline::class, 'idkeyproducto');
	}
}
