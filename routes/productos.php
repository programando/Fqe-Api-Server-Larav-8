<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Productos\ProductosVentaOnlineController;
 

Route::controller( ProductosVentaOnlineController::class )
->prefix('ventas/online/')
->group ( function () {
        Route::get('productos'                                       , 'Productos') ;
        Route::post('producto/presentaciones'                         , 'ProductoPresentaciones') ;
 
});
