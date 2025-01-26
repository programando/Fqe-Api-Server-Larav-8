<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PedidosDtVentaOnline extends Model
{
	protected $table = 'pedidos_dt_venta_online';
	protected $primaryKey = 'idpddo_dt';
	public $timestamps = false;

	protected $casts = [
		'idpddo' => 'int',
		'idproducto' => 'int',
		'cantidad' => 'float',
		'vr_unitario' => 'float',
		'vr_total' => 'float'
	];

	protected $fillable = [
		'idpddo',
		'idproducto',
		'cantidad',
		'vr_unitario',
		'vr_total'
	];

	public function Pedido()	{
		return $this->belongsTo(PedidosVentaOnline::class, 'idpddo');
	}

	public function Productos()	{
		return $this->belongsTo(ProductosVentaOnline::class, 'idproducto', 'idproducto');
	}
}
