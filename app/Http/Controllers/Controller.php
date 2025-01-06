<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getText( $value ){
        return $value  ?? '';
      }
  
      protected function getNumber( $value ){
        return $value  ?? 0;
      }
  
      protected function getBit( $value ){
        return isset($value) ? (bool)$value : false;
      }
      
}
