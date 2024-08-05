<?php

namespace App\Traits;

use App\Librarys\GuzzleHttp;
use App\Models\FctrasElctrncasMcipio;
 
use Cache;
trait ApiSoenac {
   public $ApiSoenac, $Letra ;
      
      

      public function __construct ( GuzzleHttp   $GuzzleHttps) {
         $this->ApiSoenac = $GuzzleHttps; 
      }

      public function traitSoenacResolutions() {
         // $Resoluciones = Cache::tags('ResolucAgosto2024')
         //            ->rememberForEver('ResolucAgosto2024', function() {
         //                     return $this->ApiSoenac->getRequest('config/resolutions' ) ; 
         //           }
         //   );
         // return  $Resoluciones  ;
         return $this->ApiSoenac->getRequest('config/resolutions' ) ; 
      }
      //Cambio de resoluciones Ultimos cambio
      public function traitSoenacResolutionsInvoice() {
         //$Resolutions =   $this->traitSoenacResolutions();  
         $Resolutions =   $this->ApiSoenac->getRequest('config/resolutions' ) ; 
         dd( $Resolutions);
         foreach ($Resolutions as $Resolution) {
            if ( $Resolution['id'] == 12 ){
               return $Resolution;
            }
         }
      }

      public function traitSoenacResolutionsNotes() {
         $Resolutions =   $this->traitSoenacResolutions();  
         foreach ($Resolutions as $Resolution) {
            if ( $Resolution['id'] === 5 ){
               return $Resolution;
            }
         }
      }


        public function traitSoenacTables()   {
            $response =    $this->ApiSoenac->getRequest('listings' ) ;
            $Municipios  = $response['municipalities'];
            foreach ($Municipios as $Municipio) {
                $Registro               = new FctrasElctrncasMcipio();
                $Registro['id_mcpio']   = $Municipio['id'];
                $Registro['cod_mcpio']  = $Municipio['code'];
                $Registro['name_mcpio'] = $Municipio['name'];
                $Registro->save();
            }
        }


}
