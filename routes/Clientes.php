
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TercerosClientesController;
 
 
Route::controller( TercerosClientesController::class )
            ->prefix('clientes/')
            ->group ( function () {
                    Route::post('nuevo/registro'                         , 'NuevoRegistro'              );
                    Route::post('buscar/email'                           , 'BuscarEmail'                );
                    Route::post('buscar/identificacion'                  , 'BuscarIdentificacion'       );
    });

 
?>