<?php
namespace App\Helpers;

use Cache;
use File;
use Str;
use Storage;

class FilesHelper {

 

/*        if (!function_exists('FileName')) { */
      /** * MARZO 18 2018
       * Retorna un nombre unico de archivo*/
      function FileName( $File, $Hach ) {
            return 'file_' . $Hach.'.'.$File->getClientOriginalExtension();
      }
   
   
      /** * MARZO 18 2018
       * Retorna un nombre unico de archivo*/
      public static function Extension ( $File ) {
         return strtolower($File->getClientOriginalExtension());
      }
   
      /** MARZO 18 2018
       * Retorna un nombre unico de archivo */
      function FileUnqName( $File ) {
            return  'file_' . time().'.'.$File->getClientOriginalExtension();
      }


      public static function MakeFileName ( $archivo ){
      
        return strtolower(Str::slug( uniqid()).'.'. self::Extension($archivo)) ;
      }

      public static function DestroyFile ( $existingImage ){
         if ($existingImage && Storage::exists("public/images/productos_ventas_online/" . $existingImage)) {
            Storage::delete("public/images/productos_ventas_online/" . $existingImage);
        }
       }

}