<?php

namespace App\Helpers;

class NumbersHelper {


   public static function jsonFormat( $value, $decimals) {
      return number_format ( $value, $decimals, '.', '');
   }

   public static function invoiceFormat($value) {
      return number_format( $value, 0, ",", ".");
   }
   public static function invoiceFormatExport($value) {
      return number_format( $value, 2, ",", ".");
   }

}
?>