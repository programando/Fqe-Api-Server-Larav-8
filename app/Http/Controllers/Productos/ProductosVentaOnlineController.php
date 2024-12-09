<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductosVentaOnline as Productos;
use App\Models\ProductosVentaOnlineImagene as Imagenes;
use App\Models\ProductosVentaOnlineRelacionado as PrdRelacionados;

use Str;
use Files;
use Storage;
use Log;

class ProductosVentaOnlineController extends Controller
{
    
    public function ProductoActualizar (Request $FormData) {
        try{
            $Producto                = Productos::where('idproducto', $FormData->idproducto)->first();
            $Producto->detalles      = $this->getText($FormData->detalles);
            $Producto->ficha_tecnica = $this->getText($FormData->ficha_tecnica);     
            $Producto->es_combo      = 0;
            $Producto->inactivo      = $this->getBit($FormData->inactivo);
            $Producto->publicado     = $this->getBit($FormData->publicado);
            $Producto->save();
            $this->ImagenPrincipalUpdate        ( $FormData, $Producto->idproducto);           //  main_image
            $this->ImagenesProductoUpdate       ( $FormData, $Producto->idproducto);          //  images
            $this->ProductoRelacionadosUpdate   ( $FormData, $Producto->idproducto);      //  Relacionados
            return $Producto;
        } catch(\Exception $e ) {
            Log::error("Error actualizando producto : ".$e->getMessage());
        }
    }

    private function ImagenPrincipalUpdate( $FormData, $IdProducto ) {//  main_image
        $this->ImagenPrincipalBorrar($IdProducto  );
        $Producto      = Productos::find($IdProducto );    
        try{
            if ( $FormData->file('main_image')) {

                $archivo         = $FormData->file('main_image');
                $FileName        = Files::MakeFileName($archivo ) ;
                $FilePath        = $archivo->storeAs("", $FileName , 'Productos');
                $Producto->image = $FileName;
                $Producto->save();
            }
        }catch (\Exception $e ) {
            Log::error("Error creando imagen principal: ".$e->getMessage());
        }
    }

    private function ImagenPrincipalBorrar ( $IdProducto ){
        $producto      = Productos::find($IdProducto );
        $existingImage = $producto->image;
        Files::DestroyFile( $producto->image);         // Eliminar la imagen antigua si existe
    }


    private function ImagenesProductoUpdate( $FormData, $IdProducto ) {//  images
        if ( !$FormData->has('imagenes')) return ;
        
        $this->ImagenesProductoBorrar ( $FormData, $IdProducto  );
        $Imagenes = $FormData->file('imagenes');
        
        foreach( $Imagenes  as $file) {
            $archivo         = $file;
            $FileName        = Files::MakeFileName($archivo ) ;
            $FilePath        = $archivo->storeAs("", $FileName , 'Productos');
            Imagenes::create([
                'idproducto' => $IdProducto,
                'image'      => $FileName ,         
                'inactivo'   => 0,              
            ]);
        }
    }

    private function ImagenesProductoBorrar( $FormData, $IdProducto ) {//  images
        if ( !$FormData->has('imagenes')) return ;
        $Imagenes = Imagenes::where('idproducto', $IdProducto)->get();
        foreach (  $Imagenes as $Image) {
            Files::DestroyFile( $Image['image']);
        }
        // Borrar los registros relacionados con el producto en la tabla de imágenes
        Imagenes::where('idproducto', $IdProducto)->delete();
        
    }



    private function ProductoRelacionadosUpdate( $FormData, $IdProducto) {//  relacionados
        if ( !$FormData->has('relacionados')) return ;

        PrdRelacionados::where('idproducto', $IdProducto)->delete();
        $Relacionados = $FormData->relacionados;
        foreach ( $Relacionados as $Producto ) {
            PrdRelacionados::create([
                'idproducto'        => $IdProducto,
                'idproducto_rlcndo' => $Producto['idproducto'],
            ]);          
        }
    }

    public function ProductosCrearCombos (Request $FormData) {
        return 0;
    }



    public function Productos () {
        return Productos::Productos();
    }

    public function ProductoPresentaciones (Request $FormData) {
        return Productos::ProductoPresentaciones($FormData->idproducto_ppal );
    }
    
    public function ProductoPresentacionesTodos ( ) {
        return Productos::ProductoPresentacionesTodos( );
    }

    
}
