
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TercerosAdminController;
 
 
Route::controller( TercerosAdminController::class )
            ->prefix('administradores/')
            ->group ( function () {
                    Route::post('validar/email'                         , 'ValidarEmail'              );

    });

/*
    administradores/validar/email

*/
    
?>


