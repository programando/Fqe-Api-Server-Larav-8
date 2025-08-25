<?php
 

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Folders;

class ProductosVentaOnline extends Model
{
	protected $table = 'productos_venta_online';
	protected $primaryKey = 'idkeyproducto';
	public $timestamps = false;

	protected $casts = [
		'idproducto'             => 'int',
		'costo_venta'            => 'float',
		'precio_venta'           => 'float',
		'prcntje_iva'            => 'float',
		'peso_kg'                => 'float',
		'es_combo'               => 'bool',
		'inactivo'               => 'bool',
		'publicado'              => 'bool',
		'precio_venta_obsequios' => 'float',
	];

	protected $fillable = [
		'idproducto',
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
		'publicado',
		'precio_venta_obsequios',
		'precio_venta',
		'costo_venta',
	];

	protected $attributes = ['detalles' => ''];
	protected $appends  = [  'image_url', 'url_producto', 'precio_venta_final'  ];
	 
	public static function ShopProductos (  ) {
		return 
			self::select('idproducto_ppal' , 'nomproducto', 'image' )
				->where('inactivo', '0')
				->where('publicado', '1')
				->where('precio_venta', '>', '0')
				->where('idproducto_ppal', '!=', '')
				->whereNotNull('idproducto_ppal')
				->distinct()
				->inRandomOrder()
				->get();  
	}

	public static function ProductoPresentaciones($IdProductoPpal) {
		return self::with(['Imagenes', 'Relacionados.Productos'])
			->where('idproducto_ppal', "$IdProductoPpal")
			->where('inactivo', "0")
			->select('*')
			->get();
	}
 

	public static function ProductoPresentacionesTodos() {
		return self::with(['Imagenes', 'Relacionados.Productos'])
			->where('inactivo', "0")
			->where('es_combo', "0")
			->select('*')
			->orderBy('nomproducto')
			->get();
	}

	public static function ProductoBuscarId( $IdKeyProducto) {
		return self::with(['Imagenes', 'Relacionados.Productos'])
			->where('inactivo', "0")
			->where('idkeyproducto', $IdKeyProducto)
			->select('*')
			->get();
	}

	public static function ProductoCombosTodos() {
		return self::where('es_combo', "1")
			->select('*')
			->get();
	}
		
	public static function ProductoComboPorIdKeyProducto ($IdKeyProducto) {
		return self::with(['Imagenes', 'ProductosComponenCombo'])
			->where('idkeyproducto', $IdKeyProducto)
			->select('*')
			->get();
	}
	
	 
	public static function ProductosActualizarCampo($IdKeyProducto, $Campo, $NewValue) {
		return self::where('idkeyproducto', $IdKeyProducto)->update([$Campo => $NewValue]); 
	}
	
 

	public function ProductosComponenCombo(){
		return $this->hasMany(ProductosVentaOnlineCombo::class, 'idkeyproducto');
	}


	public function getImageUrlAttribute() {  
		return Folders::ProductosVenta($this->image );  
	}

	public function getUrlProductoAttribute() {  
		return config('company.APP_URL')."/productos/$this->idproducto_ppal";  
	}

	public function getPrecioVentaFinalAttribute() {
		return $this->precio_venta - $this->precio_venta_obsequios;
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

 
	public function Imagenes()	{
		return $this->hasMany(ProductosVentaOnlineImagene::class, 'idkeyproducto');
	}

	public function Relacionados()	{
		return $this->hasMany(ProductosVentaOnlineRelacionado::class, 'idkeyproducto');
	}

	
}
