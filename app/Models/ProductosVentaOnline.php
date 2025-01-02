<?php
 

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Folders;

class ProductosVentaOnline extends Model
{
	protected $table = 'productos_venta_online';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'idproducto' => 'int',
		'costo_venta' => 'float',
		'precio_venta' => 'float',
		'prcntje_iva' => 'float',
		'peso_kg' => 'float',
		'es_combo' => 'bool',
		'inactivo' => 'bool',
		'publicado' => 'bool'
	];

	protected $fillable = [
		'idproducto_ppal',
		'uuid',
		'nomproducto',
		'nom_prsntacion',
		'detalles',
		'costo_venta',
		'precio_venta',
		'prcntje_iva',
		'peso_kg',
		'ficha_tecnica',
		'image',
		'es_combo',
		'inactivo',
		'publicado'
	];


	protected $attributes = ['detalles' => ''];
	protected $appends  = [  'image_url'  ];
	 
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
			->where('inactivo', "0")
			->select('id','idproducto','idproducto_ppal', 'nomproducto', 'nom_prsntacion', 'precio_venta', 'prcntje_iva', 'peso_kg', 'ficha_tecnica')
			->get();
	}

	public static function ProductoPresentacionesTodos() {
		return self::with(['Imagenes', 'Relacionados.Productos'])
			->where('inactivo', "0")
			->select('id','idproducto','idproducto_ppal', 'nomproducto', 'nom_prsntacion', 'precio_venta', 'prcntje_iva', 'peso_kg', 'ficha_tecnica')
			->get();
	}

	public static function ProductoBuscarId( $IdProducto) {
		return self::with(['Imagenes', 'Relacionados.Productos'])
			->where('inactivo', "0")
			->where('idproducto', $IdProducto)
			->select('id','idproducto',	'idproducto_ppal','uuid','nomproducto','nom_prsntacion','detalles','costo_venta','precio_venta','prcntje_iva','peso_kg','ficha_tecnica','image','es_combo','inactivo','publicado')
			->get();
	}

	public static function ProductoCombosTodos() {
		return self::where('es_combo', "1")
			->select('id','idproducto',	'idproducto_ppal','uuid','nomproducto','nom_prsntacion','detalles','costo_venta','precio_venta','prcntje_iva','peso_kg','ficha_tecnica','image','es_combo','inactivo','publicado')
			->get();
	}



	public function getImageUrlAttribute() {  
		return Folders::ProductosVenta($this->image );  
	}

	public function Imagenes()	{
		return $this->hasMany(ProductosVentaOnlineImagene::class, 'idproducto');
	}

	public function Relacionados()	{
		return $this->hasMany(ProductosVentaOnlineRelacionado::class, 'idproducto');
	}

	public function Combos()	{
		return $this->hasMany(ProductosVentaOnlineCombo::class, 'idproducto');
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
