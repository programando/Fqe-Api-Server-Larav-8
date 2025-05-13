<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 
class ProductosVentaOnlineCombo extends Model
{
	protected $table = 'productos_venta_online_combos';
	protected $primaryKey = 'idcombo_dt';
	public $timestamps = false;

	protected $casts = [
		'idkeyproducto' => 'int',
		'idproducto' => 'int',
		'cantidad' => 'int',
		'es_obsequio' => 'bool'
	];

	protected $fillable = [
		'idkeyproducto',
		'idproducto',
		'cantidad',
		'es_obsequio',
		'precio_venta',
		'costo_venta',
	];


	 
	public static function ProductosComponentes ( $IdKeyProducto ) {
		return self::with('Productos')
					->where('idkeyproducto',$IdKeyProducto )->get();
	}
	 

	public function Productos()	{
		return $this->belongsTo(ProductosVentaOnline::class, 'idkeyproducto');
	}
}
