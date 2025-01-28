<?php

namespace App\Helpers;

use Carbon\Carbon;

class DatesHelper {

 

    
   public static function YMD( $value ) {
        $date = Carbon::parse($value);
        if ($date && $date->isValid()) {
            return $date->format('Y-m-d');
        }
   }

   public static function DMY( $value ) {
        return date_format($value, 'd/mm/Y');
   }

    public static function HOUR($value) {
    // Asegúrate de que $value sea un objeto DateTime o una instancia de Carbon
    if (!$value instanceof DateTime) {
        $value = new DateTime($value);
    }

    // Formatea la hora en el formato deseado
    return $value->format('H:i:s');
    }

    public static function AddHoras ( $Horas=1) {
        return Carbon::now()->addHours($Horas);
    }

    public static function DocumentDate ( $Value ){
      return Carbon::createFromFormat('Y-m-d H:i:s', $Value);  
    }

    private function checkStringDate(  $value){
      if (date('d-m-Y', strtotime( $value )) == $value ) {
        $this->Fecha = $value;
        } else {
            return false;
        }
    }

    public static function getHoy() {
        return Carbon::now();
    }
    
/* $fecha = "2018-03-29 15:20:40";

$dt = new DateTime($fecha);
print $dt->format('d/m/Y'); // imprime 29/03/2018
 */


     /* ENERO 21 2019
        VALIDA QUE LA FECHA DE DESPACHO SEA VALIDA */
    public static function pedidosFechaDspachoValidar( $FechaDespacho ) {
        $FechaDespacho = Carbon::parse($FechaDespacho)->format('Y-m-d');
        $Hoy           = Carbon::now()->format('Y-m-d');
        if ( $FechaDespacho < $Hoy ){
            $FechaDespacho = $Hoy;
        }
        return Carbon::parse( $FechaDespacho );
    }

    
}
?>