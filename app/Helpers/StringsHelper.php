<?php

namespace App\Helpers;

class StringsHelper {


   public static function isEmptyOrNull( $value ) {
       $value  = trim($value );
      if ( empty($value) or is_null( $value )  ) {
                return true;
            }else {
                return false;
            }
      }

    public static function UpperTrim( $String, $Long=0 ) {
        if ( $Long== 0 ) $Long = strlen( trim($String));
        $String = trim( $String );
        $String = preg_replace('/\s\s+/', ' ', $String  );
        $String = substr($String, 0, $Long  );
        $String = mb_strtoupper( $String,'UTF-8');
        return $String;
    }
    
    public static function LowerTrim ( $String) {
           $String = trim( $String );
           return mb_strtolower( $String,'UTF-8'); 
    }
 
    
    public static   function UUID () {
            $datos = random_bytes(16);

            // Forzamos la versión 4
            $datos[6] = chr((ord($datos[6]) & 0x0f) | 0x40);
            // Forzamos la variante RFC 4122
            $datos[8] = chr((ord($datos[8]) & 0x3f) | 0x80);

            return sprintf(
                '%08s-%04s-%04s-%04s-%12s',
                bin2hex(substr($datos, 0, 4)),
                bin2hex(substr($datos, 4, 2)),
                bin2hex(substr($datos, 6, 2)),
                bin2hex(substr($datos, 8, 2)),
                bin2hex(substr($datos, 10, 6))
            );
    }
    
}
?>