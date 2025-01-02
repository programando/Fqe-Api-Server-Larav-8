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
		'idkeyproducto' => 'int',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'idkeyproducto',
		'image',
		'inactivo'
	];
	protected $appends  = [  'url'  ];

	public function Productos()	{
		return $this->belongsTo(ProductosVentaOnline::class, 'idkeyproducto');
	}

	public function getUrlAttribute() {  
		return Folders::ProductosVenta($this->image );  
	}
	
}
