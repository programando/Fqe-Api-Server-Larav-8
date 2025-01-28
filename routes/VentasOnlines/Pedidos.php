<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PedidosVentaOnlineController;
 

Route::controller( PedidosVentaOnlineController::class )
        ->prefix('ventas/online/pedidos/')
        ->group ( function () {
                Route::post('crear/nuevo/pedido'                             , 'PedidoCrearNuevo') ;
                Route::post('confirmacion/pago/recibido'                     , 'PedidoConfirmacionPagoRecibido') ;
});


