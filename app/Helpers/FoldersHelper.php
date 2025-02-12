<?php
namespace App\Helpers;

class FoldersHelper {

     /** * MARZO 18 2018.  Retorna ruta base para el almacenamiento de imagenes */
    public static function UserImages() {
       return   asset('storage/images/users/');
    }

    public static function Images ( $Archivo ) {
       return   asset('storage/images/'.$Archivo);
    }

    public static     function ImagesApp( ) {
       return    asset('storage/images/app/');
   }

   public static function cssFile( $archivo ) {
       return    asset('public/storage/css/'.$archivo) ;
   }

   public static function ProductsImages () {
      return asset('storage/images/productos') ; 
   }

   public static function LineasImages () {
      return asset('storage/images/lineas') ; 
   }
  
    public static function ProductsImagesFolder () {
      return asset('storage/images/productos') ; // storage_path('app/public/images/productos');
   }

   public static function ProductosVenta ( $file ) {
      return asset("storage/images/productos_ventas_online/$file") ; // storage_path('app/public/images/productos');
   }

}