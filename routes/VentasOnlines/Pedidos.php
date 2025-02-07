<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PedidosVentaOnlineController;
use App\Http\Controllers\ParametrosVentasOnlineController;
 

Route::controller( PedidosVentaOnlineController::class )
        ->prefix('ventas/online/pedidos/')
        ->group ( function () {
                Route::post('crear/nuevo/pedido'                             , 'PedidoCrearNuevo') ;
                Route::post('confirmacion/pago/recibido'                     , 'PedidoConfirmacionPagoRecibido') ;
});



Route::controller( ParametrosVentasOnlineController::class )
        ->prefix('parametros/')
        ->group ( function () {
                Route::get('consultar'                             , 'ParametrosConsultar') ;
});

