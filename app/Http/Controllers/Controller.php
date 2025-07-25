<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

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

      protected function HandleErrorDocuments($documento, \Exception $exception)
      {
          Log::error("Error procesando documento electrónico:" . PHP_EOL .
              "ID Factura Electrónica: " . $documento->centro_costo . PHP_EOL .
              "Centro: " . $documento->prfjo_dcmnto . PHP_EOL .
              "Prefijo: " . $documento->prfjo_dcmnto . PHP_EOL .
              "Número: " . ($documento->number ?? 'N/A') . PHP_EOL .
              "Mensaje de Error: " . $exception->getMessage() . PHP_EOL .
              "Archivo: " . $exception->getFile() . PHP_EOL .
              "Línea: " . $exception->getLine() . PHP_EOL .
              "Traza: " . $exception->getTraceAsString()
          );
      }

      protected function HandleError($Proceso, \Exception $exception)
      {
          Log::error("Error en $Proceso :" . PHP_EOL .
              "Mensaje de Error: " . $exception->getMessage() . PHP_EOL .
              "Archivo: " . $exception->getFile() . PHP_EOL .
              "Línea: " . $exception->getLine() . PHP_EOL .
              "Traza: " . $exception->getTraceAsString()
          );
      }

        protected function Response($data = null, $message = '', $success = true, $code = 200, $error = null)
    {
        return response()->json([
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $code);
    }

    protected function ResponseError($message, $code = 400, $error = null)
    {
        return response()->json([
            'success' => false,
            'code' => $code,
            'message' => $message,
            'error' => $error
        ], $code);
    }

      
}
