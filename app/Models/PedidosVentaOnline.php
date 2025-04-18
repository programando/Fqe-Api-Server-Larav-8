<?php

 
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

 
class PedidosVentaOnline extends Model
{
	protected $table = 'pedidos_venta_online';
	protected $primaryKey = 'idpddo';
	public $timestamps = false;

	protected $casts = [
		'idtercero'            => 'int',
		'peso_kg'              => 'float',
		'vr_pddo'              => 'float',
		'vr_flete'             => 'float',
		'vr_total'             => 'float',
		'pddo_en_fqe'          => 'bool',
		'pago_recibido'        => 'bool',
		'email_pddo_gnrdo'     => 'bool',
		'facturado'            => 'bool',
		'email_pddo_pgdo'      => 'bool',
		'fqe_idpedido'         => 'int',
		'fqe_idcontrolfactura' => 'int'
	];

	protected $dates = [
		'fcha_pddo',
		'fecha_vence'
	];

	protected $fillable = [
		'idtercero',
		'fcha_pddo',
		'fecha_vence',
		'peso_kg',
		'vr_pddo',
		'vr_flete',
		'vr_total',
		'pddo_en_fqe',
		'pago_recibido',
		'email_pddo_gnrdo',
		'facturado',
		'email_pddo_pgdo',
		'fqe_idpedido',
		'fqe_idcontrolfactura',
		'payu_reference',
		'payu_signature',
	];

	public function PedidoDtProductos()	{
		return self::with('PedidoDt.Producto')->get();
	}

	public function Cliente()	{
		return $this->belongsTo(Tercero::class, 'idtercero');
	}

	public function PedidoDt()	{
		return $this->hasMany(PedidosDtVentaOnline::class, 'idpddo');
	}
}
