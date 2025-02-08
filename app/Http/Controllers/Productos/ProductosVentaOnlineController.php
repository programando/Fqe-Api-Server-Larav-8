<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductosVentaOnline as Productos;
use App\Models\ProductosVentaOnlineImagene as Imagenes;
use App\Models\ProductosVentaOnlineRelacionado as PrdRelacionados;
use App\Models\ProductosVentaOnlineCombo as PrdComponenCombo;

use Str;
use Files;
use Storage;
use Log;

class ProductosVentaOnlineController extends Controller
{
    
    public function ProductoActualizar (Request $FormData) {
        try{
            $Producto                = Productos::where('idkeyproducto', $FormData->idkeyproducto)->first();
            $Producto->detalles      = $this->getText($FormData->detalles);
            $Producto->ficha_tecnica = '' ;      
            $Producto->es_combo      = 0;
            $Producto->inactivo      = $this->getBit($FormData->inactivo);
            $Producto->publicado     = $this->getBit($FormData->publicado);
            $Producto->save();
            $this->ImagenPrincipalUpdate        ( $FormData, $Producto->idkeyproducto);           
            $this->ImagenesProductoUpdate       ( $FormData, $Producto->idkeyproducto);         
            $this->ProductoRelacionadosUpdate   ( $FormData, $Producto->idkeyproducto);     
            return $Producto;
        } catch(\Exception $e ) {
            Log::error("Error actualizando producto : ".$e->getMessage());
        }
    }

    private function ImagenPrincipalUpdate( $FormData, $IdKeyProducto ) {//  main_image
        $this->ImagenPrincipalBorrar($IdKeyProducto  );
        $Producto      = Productos::find($IdKeyProducto );    
        try{
            if ( $FormData->file('main_image')) {
                $archivo         = $archivo = $FormData->file('main_image')[0]['file'];;
                $FileName        = Files::MakeFileName($archivo ) ;
                $FilePath        = $archivo->storeAs("", $FileName , 'Productos');
                $Producto->image = $FileName;
                $Producto->save();
            }
        }catch (\Exception $e ) {
            Log::error("Error creando imagen principal: ".$e->getMessage());
        }
    }

    private function ImagenPrincipalBorrar ( $IdKeyProducto){
        $producto      = Productos::find($IdKeyProducto);
        $existingImage = $producto->image;
        Files::DestroyFile( $producto->image);         // Eliminar la imagen antigua si existe
    }


    private function ImagenesProductoUpdate( $FormData, $IdKeyProducto ) {//  images
        if ( !$FormData->has('images')) return ;
        
        $this->ImagenesProductoBorrar ( $FormData, $IdKeyProducto  );
        $Imagenes = $FormData->file('images');
        foreach( $Imagenes  as $file) {
            $archivo = $file['file'];
            $FileName        = Files::MakeFileName( $archivo) ;
            $FilePath        = $archivo->storeAs("", $FileName , 'Productos');
            Imagenes::create([
                'idkeyproducto' => $IdKeyProducto,
                'image'         => $FileName,
                'inactivo'      => 0,
            ]);
        }
    }

    private function ImagenesProductoBorrar( $FormData, $IdKeyProducto ) {//  images
        if ( !$FormData->has('imagenes')) return ;
        $Imagenes = Imagenes::where('idkeyproducto', $IdKeyProducto)->get();
        foreach (  $Imagenes as $Image) {
            Files::DestroyFile( $Image['image']);
        }
        // Borrar los registros relacionados con el producto en la tabla de imágenes
        Imagenes::where('idkeyproducto', $IdKeyProducto)->delete();
        
    }



    private function ProductoRelacionadosUpdate( $FormData, $IdKeyProducto) {//  relacionados
        if ( !$FormData->has('relacionados')) return ;

        PrdRelacionados::where('idproducto', $IdKeyProducto)->delete();
        $Relacionados = $FormData->relacionados;
        foreach ( $Relacionados as $Producto ) {
            PrdRelacionados::create([
                'idkeyproducto'        => $IdKeyProducto,
                'idproducto' => $Producto['idproducto'],
            ]);          
        }
    }

 

    public function ProductoComboCrearActualizar (Request $FormData) {
       
        $Producto             = Productos::where('idkeyproducto', $FormData->idkeyproducto)->first();
        if (!$Producto)       $Producto = new Productos();
  
        try{
            $Producto->nomproducto    = $this->getText($FormData->nomproducto);
            $Producto->nom_prsntacion = 'Unidad';
            $Producto->detalles       = $this->getText($FormData->detalles);
            $Producto->ficha_tecnica  = '' ;
            $Producto->es_combo       = 1;
            $Producto->inactivo       = $this->getBit($FormData->inactivo);
            $Producto->publicado      = $this->getBit($FormData->publicado);
            $Producto->save();
            $this->ImagenPrincipalUpdate        ( $FormData, $Producto->idkeyproducto);           
            $this->ImagenesProductoUpdate       ( $FormData, $Producto->idkeyproducto);            
             $this->ProductosComponenCombo       ( $FormData, $Producto->idkeyproducto);            
            return $Producto;
        } catch(\Exception $e ) {
            Log::error("Error actualizando producto : ".$e->getMessage());
        }
    }


    private function ProductosComponenCombo( $FormData, $IdKeyProducto) { 
        $Combo_PesoKg = 0; $Combo_PrecioVenta = 0; $Combo_PrecioVentaObsequios = 0;
        if ( !$FormData->has('ProductosComponenCombo')) return ;

        PrdComponenCombo::where('idkeyproducto', $IdKeyProducto)->delete();
        $ProductosComponenCombo = $FormData->ProductosComponenCombo;
        $ProductosCombo = [];

        foreach ( $ProductosComponenCombo as $Producto ) {
            $ProductoComponeCombo = Productos::where('idproducto', $Producto['idproducto'])->first();
            $EsObequio = $this->getBit( $Producto['es_obsequio']  );
            $ProductosCombo[]     = [
                'idkeyproducto' => $IdKeyProducto,
                'cantidad'      => $Producto['cantidad'],
                'idproducto'    => $Producto['idproducto'],
                'es_obsequio'   => $EsObequio ,
            ]; 
            $Combo_PesoKg      += ($ProductoComponeCombo->peso_kg        * $Producto['cantidad']);
            if ( !$EsObequio ) $Combo_PrecioVenta += ($ProductoComponeCombo->precio_venta   * $Producto['cantidad']);
            if ( $EsObequio ) $Combo_PrecioVentaObsequios += ($Combo_PrecioVentaObsequios->precio_venta   * $Producto['cantidad']);
        }
      
        if ( $ProductosCombo ) {
            PrdComponenCombo::insert($ProductosCombo  );
            $this->ComboActualizarPesoPrecio( $IdKeyProducto, $Combo_PesoKg, $Combo_PrecioVenta, $Combo_PrecioVentaObsequios );
        }
    }
 
    private function ComboActualizarPesoPrecio( $IdKeyProducto,$Combo_PesoKg, $Combo_PrecioVenta ) {
        $ComboCreadoActualizado                         = Productos::where('idkeyproducto', $IdKeyProducto)->first();
        $ComboCreadoActualizado->peso_kg                = $Combo_PesoKg;
        $ComboCreadoActualizado->precio_venta           = $Combo_PrecioVenta;
        $ComboCreadoActualizado->precio_venta_obsequios = $Combo_PrecioVenta;
        $ComboCreadoActualizado->save();
    }


    public function ShopProductos () {
        return Productos::ShopProductos();
    }

    public function ProductoBuscarId ( request $FormData) {
        return Productos::ProductoBuscarId($FormData->idkeyproducto);
    }

    public function ProductoPresentaciones (Request $FormData) {
        return Productos::ProductoPresentaciones($FormData->idproducto_ppal );
    }
    
    public function ProductoPresentacionesTodos ( ) {
        return Productos::ProductoPresentacionesTodos( );
    }

    public function ProductoCombosTodos ( ) {
        return Productos::ProductoCombosTodos( );
    }

    public function ProductoComboPorIdKeyProducto ( Request $FormData ) {
        return Productos::ProductoComboPorIdKeyProducto( $FormData->idkeyproducto );
    }

    public function ProductoActualizarCampo (Request $FormData) {
        
        Productos::ProductosActualizarCampo ( $FormData->idkeyproducto, $FormData->nombre_campo, $FormData->new_value );
        return 'Ok';
    }
    
}
