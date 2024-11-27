<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Folders;

class ProductosVentaOnline extends Model
{
	protected $table = 'productos_venta_online';
	protected $primaryKey = 'idproducto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idproducto' => 'int',
		'costo_venta' => 'float',
		'precio_venta' => 'float',
		'prcntje_iva' => 'float',
		'peso_kg' => 'float',
		'inactivo' => 'bool'
	];

	protected $fillable = [
		'idproducto_ppal',
		'uuid',
		'nomproducto',
		'nom_prsntacion',
		'costo_venta',
		'precio_venta',
		'prcntje_iva',
		'peso_kg',
		'ficha_tecnica',
		'inactivo',
		'detalles',
		'image'
	];

	protected $appends  = [  'url'  ];
	 
	public static function Productos (  ) {
		return 
			self::select('idproducto_ppal' , 'nomproducto', 'image' )
				->distinct()
				->inRandomOrder()
				->get();  
	}

	public static function ProductoPresentaciones($IdProductoPpal) {
		return self::with(['Imagenes', 'Relacionados.Productos'])
			->where('idproducto_ppal', "$IdProductoPpal")
			->select('idproducto','idproducto_ppal', 'nomproducto', 'nom_prsntacion', 'precio_venta', 'prcntje_iva', 'peso_kg', 'ficha_tecnica')
			->get();
	}


	public function getUrlAttribute() {  
		return Folders::ProductosVenta($this->image );  
	}

	public function Imagenes()	{
		return $this->hasMany(ProductosVentaOnlineImagene::class, 'idproducto');
	}

	public function Relacionados()	{
		return $this->hasMany(ProductosVentaOnlineRelacionado::class, 'idproducto');
	}
 

	public function getNomproductoAttribute ( $value ){
		return trim( $value) ;
	}

	public function getNomPrsntacionAttribute ( $value ){
		return trim( $value) ;
	}

	public function getDetallesAttribute ( $value ){
		return trim( $value) ;
	}
}
