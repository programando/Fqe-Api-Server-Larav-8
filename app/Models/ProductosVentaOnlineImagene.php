<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Folders;
class ProductosVentaOnlineImagene extends Model
{
	protected $table = 'productos_venta_online_imagenes';
	protected $primaryKey = 'idregistro';
	public $timestamps = false;

	protected $casts = [
		'idproducto' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'idproducto',
		'image',
		'inactivo'
	];
	protected $appends  = [  'url'  ];

	public function Productos()	{
		return $this->belongsTo(ProductosVentaOnline::class, 'idproducto');
	}

	public function getUrlAttribute() {  
		return Folders::ProductosVenta($this->image );  
	}
}
