<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 
class ProductosVentaOnlineCombo extends Model
{
	protected $table = 'productos_venta_online_combos';
	protected $primaryKey = 'idcombo_dt';
	public $timestamps = false;

	protected $casts = [
		'idproducto' => 'int',
		'idproducto_combo' => 'int',
		'cantidad' => 'int',
		'es_obsequio' => 'bool'
	];

	protected $fillable = [
		'idproducto',
		'idproducto_combo',
		'cantidad',
		'es_obsequio'
	];

	public function ProdcuctoOnline() {
		return $this->belongsTo(ProductosVentaOnline::class, 'idproducto_combo');
	}
	
}
