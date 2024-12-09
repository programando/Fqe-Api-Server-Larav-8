<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductosVentaOnline as Productos;

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
            $Producto->save();
            $this->ImagenPrincipalUpdate( $FormData, $Producto->idproducto);           //  main_image
            $this->ImagenesProductoUpdate( $FormData);          //  images
            $this->ProductoRelacionadosUpdate( $FormData);      //  productos_relacionados 
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


    private function ImagenesProductoUpdate( $FormData) {//  images
        if ( !$FormData->main_image) return ;

    }


    private function ProductoRelacionadosUpdate( $FormData) {//  productos_relacionados
        if ( !$FormData->main_image) return ;

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
